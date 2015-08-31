<?php

namespace BdE\MainBundle\Admin;

use BdE\MainBundle\Entity\AzureRole;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class MailAdmin extends Admin
{

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with("general")
            ->add("name")
            ->add("active",null,array('required'=>false))
            ->add("priority")
            ->end()
            ->with("conditions",array(
                'description' => 'NB: Si une condition est vide alors elle autorise tous les cas'
            ))
            ->add("forProducts")
            ->add("forYears", "choice",array(
                "multiple"=>true,
                "choices"=>array(
                    '1' => 'Première année',
                    '2' => 'Deuxième année',
                    '3' => 'Troisième année',
                    '4' => 'Quatrième année',
                    '5' => 'Cinquième année',
                    '3CYCLE' => 'Doctorants',
                    'AUTRE' => 'Non INSA',
                    'Personnel' => 'Personnel',
                )
            ))
            ->add("forDepartment", "choice", array(
                'multiple' => true,
                'choices' => array(
                    'PC' => 'Premier Cycle',
                    'BB' => 'BB',
                    'BIM' => 'BIM',
                    'GCU' => 'GCU',
                    'GE' => 'GE',
                    'GEN' => 'GEN',
                    'GI' => 'GI',
                    'GMC' => 'GMC',
                    'GMD' => 'GMD',
                    'GMPP' => 'GMPP',
                    'IF' => 'IF',
                    'SGM' => 'SGM',
                    'TC' => 'TC',
                    '' => 'Externe'
                ),
                "required" => false
            ))
            ->add("forNewMembers","choice",array(
                "choices"=>array(
                    0 => 'Critère désactivé',
                    1 => 'Nouveau membres (< 3 mois)',
                    2 => 'Anciens membres (>= 3 mois)'
                ),
                "label"=>"Ancienneté"
            ))
            ->end()
            ->with("content")
            ->add("subject")
            ->add("content","ckeditor",[
                'config' => array(
                    'toolbar' => array(
                        array('Source', '-', 'Preview', 'Print', '-', 'Templates'),
                        array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                        array('Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'),
                        array(
                            'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'SelectField', 'Button', 'ImageButton',
                            'HiddenField',
                        ),
                        '/',
                        array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                        array(
                            'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-',
                            'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
                        ),
                        array('Link', 'Unlink', 'Anchor'),
                        array('Image', 'FLash', 'Table', 'HorizontalRule', 'SpecialChar', 'Smiley', 'PageBreak', 'Iframe'),
                        '/',
                        array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
                        array('Maximize', 'ShowBlocks'),
                        array('About'),
                    ),
                    'uiColor' => '#ffffff',
                    //...
                ),
            ])
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
        ;
    }

}