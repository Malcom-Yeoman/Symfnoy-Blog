<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Hide the ID on the form view, it's auto-generated
            TextEditorField::new('content', 'Content'),
            DateTimeField::new('createdAt', 'Created At')->setFormat('short')->hideOnForm(), // Assuming that the creation time is set automatically
            AssociationField::new('user', 'User'), // Assuming you have a user association in your Comment entity
            AssociationField::new('post', 'Post'), // Assuming you have a post association in your Comment entity
            // ... add more fields as needed
        ];
    }
}