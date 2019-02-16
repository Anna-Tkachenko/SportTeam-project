<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            'content' => 'content',
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
