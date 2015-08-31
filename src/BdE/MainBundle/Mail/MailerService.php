<?php
/**
 * Created by PhpStorm.
 * User: pvienne
 * Date: 31/08/15
 * Time: 16:04
 */

namespace BdE\MainBundle\Mail;


use BdE\MainBundle\Entity\Mail;
use Cva\GestionMembreBundle\Entity\Etudiant as Student;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;

/**
 * Mailer service used to create mails.
 * @package BdE\MainBundle\Mail
 */
class MailerService
{

    private $_secret;
    private $_em;
    private $_twig;
    /**
     * @var Router
     */
    private $_router;

    /**
     * MailerService constructor.
     * @param $_secret
     * @param EntityManager $_em
     * @param \Twig_Environment $_twig
     */
    public function __construct($_secret, EntityManager $_em, \Twig_Environment $_twig)
    {
        $this->_secret = $_secret;
        $this->_em = $_em;
        $this->_twig = $_twig;
    }


    public function generateMailFromData(Mail $mail, Student $student){
        $twig = new \Twig_Environment( new \Twig_Loader_Array(
            ['mail.'.$mail->getId() => $mail->getContent()]
        ),
            array(
                'autoescape' => false
            )
        );
        $subject = ($mail->getSubject());
        $message = $this->_twig->render("@BdEMain/Mail/common.html.twig",array(
            'content' => $twig->render("mail.".$mail->getId(),array(
                'student'=>$student
            )),
            'config' => array(
                'title' => $mail->getSubject(),
                'company' => "BdE INSA Lyon",
                'student' => $student,
                'mail_id' => $this->_crypt_data($mail->getId(), $student->getId())
            ),
            'why_this_mail' => ""
        ));
        return ['subject'=>$subject,'body'=>$message];
    }

    public function generateMailFromBinData($data){
        $data = $this->_decrypt_data($data);
        if(!$data){
            throw new NotFoundHttpException("Your mail key is invalid !");
        }
        $student = $this->_em->getRepository("CvaGestionMembreBundle:Etudiant")->find($data->student);
        $mail = $this->_em->getRepository("BdEMainBundle:Mail")->find($data->mail);
        if(!$student || !$mail){
            throw new NotFoundHttpException("This mail does not exist");
        }
        return $this->generateMailFromData($mail, $student);
    }

    private function _decrypt_data($data){

        $data = base64_decode($data);
        $data = preg_split('/#/i',$data);
        $iv = base64_decode($data[0]);
        $encrypted = base64_decode($data[1]);

        $message = openssl_decrypt($encrypted, $this->_get_encryption_method(), $this->_get_secret_hash(), false, $iv);

        return json_decode($message);

    }

    private function _crypt_data($mail_id, $student_id){

        $data = json_encode([
            "mail" => $mail_id,
            "student" => $student_id
        ]);

        $iv_size = $this->_get_iv_size();
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encryptedMessage = openssl_encrypt($data, $this->_get_encryption_method(), $this->_get_secret_hash(), false, $iv);

        return base64_encode(base64_encode($iv). '#' . base64_encode($encryptedMessage));

    }

    private function _get_iv_size(){
        return 16;
    }

    private function _get_secret_hash(){
        $md5_s = md5($this->_secret);
        $sha1_s = sha1($this->_secret);
        $md5_sha1_s = md5($sha1_s);
        $md5_md5_s = md5($md5_s);
        return
            sha1($md5_md5_s) . $sha1_s . $md5_sha1_s . $md5_s . $md5_md5_s . sha1( $sha1_s.$md5_md5_s.$md5_s );
    }

    private function _get_encryption_method()
    {
        $encryptionMethod = "AES-256-CBC";
        return $encryptionMethod;
    }

}