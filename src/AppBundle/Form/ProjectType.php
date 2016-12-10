<?php
/**
 * Created by PhpStorm.
 * User: Adrian
 * Date: 03.12.2016
 * Time: 16:13
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length as LengthConstraint;
use Symfony\Component\Validator\Constraints\NotBlank as NotBlankConstraint;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", "text", [
                "required" => false,
                "constraints" => [
                    new LengthConstraint([
                        "min" => 3,
                        "max" => 50,
                    ]),
                    new NotBlankConstraint(),
                ],])
            ->add("description", "textarea", [
                "required" => false,])
            ->add("aboutText", "textarea", [
                "required" => false,])
            ->add("priority", "integer", [
                "required" => false,])
            ->add("startAt", "datetime", [
                "required" => false,])
            ->add("isClosed", "checkbox", [
                "required" => false,
                "label" => "Проект закрыт?"])
            ->add("picture", "text", [
                "required" => false,])
//            ->add("like", "integer", [
//                "required" => false,])
            ->add("submit", "submit", ['attr' => ['class' => 'btn-primary']])
            ->add("cancel", "submit");
    }
}