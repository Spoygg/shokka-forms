<?php

use ShokkaForms\Form;

class FormTest extends WP_UnitTestCase {
    public function testValidateField() {
        $post_id = $this->factory->post->create(
            array(
                'post_title' => 'Form Post',
                'post_type'  => 'post',
            )
        );
        $post = get_post( $post_id );
        $form = new Form( $post );

        $isValid = $form->validateField( 'abcd!?1.~°˛^ˇ`', 'text' );
        $this->assertTrue( $isValid );

        $isValid = $form->validateField( 1111, 'number' );
        $this->assertTrue( $isValid );

        $isValid = $form->validateField( 0, 'number' );
        $this->assertTrue( $isValid );

        $isNotValid = $form->validateField( 'abc', 'number' );
        $this->assertFalse( $isNotValid );

        $isNotValid = $form->validateField( '1abc1', 'number' );
        $this->assertFalse( $isNotValid );

        $isValid = $form->validateField( 'someone@example.com', 'email' );
        $this->assertTrue( $isValid ); 

        $isNotValid = $form->validateField( 'someoneexample.com', 'email' );
        $this->assertFalse( $isNotValid ); 

        $isValid = $form->validateField( '+(381)601234565', 'tel' );
        $this->assertTrue( $isValid, '+(381)601234565 should be a valid tel' ); 

        $isNotValid = $form->validateField( 'abc123!!!', 'tel' );
        $this->assertFalse( $isNotValid, 'abc123!!! should not be a valid tel' ); 

        $isValid = $form->validateField( '12/12/2020', 'date' );
        $this->assertTrue( $isValid );

        $isNotValid = $form->validateField( '12abc', 'date' );
        $this->assertFalse( $isNotValid );

        $isValid = $form->validateField( '12:34', 'time' );
        $this->assertTrue( $isValid, 'numbers and : are allowed in time' );

        $isNotValid = $form->validateField( '1234', 'time' );
        $this->assertFalse( $isNotValid, 'time should not be only numbers' );

        $isValid = $form->validateField( '12:34:56', 'time' );
        $this->assertTrue( $isValid, 'time should allow seconds' );

        $isNotValid = $form->validateField( ':', 'time' );
        $this->assertFalse( $isNotValid, 'time should not be only :' );
    }
}