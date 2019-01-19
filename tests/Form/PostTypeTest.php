<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 21:47
 */

namespace App\Tests\Form;


use App\Form\PostType;
use Symfony\Component\Form\Test\TypeTestCase;

class PostTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'name',
            'content' => 'content'
        ];

        $form = $this->factory->create(PostType::class);
        $form->submit($formData);
        self::assertTrue($form->isSynchronized());
        $view = $form->createView();
        $children = $view->children;
        foreach ($formData as $key=>$data) {
            self::assertArrayHasKey($key, $children);
        }
    }
}