<?php declare(strict_types=1);

namespace Bupy7\InputFilter\Test;

use Bupy7\InputFilter\Test\Asset\EmptyForm;
use Bupy7\InputFilter\Test\Asset\NullForm;
use Bupy7\InputFilter\Test\Asset\ProfileForm;
use Bupy7\InputFilter\Test\Asset\SignInAccessForm;
use Bupy7\InputFilter\Test\Asset\SignInFilter;
use Bupy7\InputFilter\Test\Asset\SignInMethodForm;
use Bupy7\InputFilter\Test\Asset\SignInPropertyForm;

final class FormAbstractTest extends TestCase
{
    public function testInstanceInputFilter(): void
    {
        $signInForm = new SignInPropertyForm();
        $signInForm->setInputFilter(new SignInFilter());
        $this->assertInstanceOf(SignInFilter::class, $signInForm->getInputFilter());
        $signInForm->setValues(['password' => '']);
        $this->assertFalse($signInForm->isValid());
    }

    public function testEmptyInputs(): void
    {
        $emptyForm = new EmptyForm();
        $emptyForm->setValues([]);
        $this->assertTrue($emptyForm->isValid());
    }

    public function testValidInputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '12q34e56t78',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertFalse($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '12q34e56t78',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertFalse($signInForm->hasErrors());
    }

    public function testInvalidInputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.never',
            'password' => '',
        ]);
        $this->assertFalse($signInForm->isValid());
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.never',
            'password' => '',
        ]);
        $this->assertFalse($signInForm->isValid());
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
    }

    public function testValidGroupInputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertFalse($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertFalse($signInForm->hasErrors());
    }

    public function testInvalidGroupInputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.never',
        ]);
        $this->assertFalse($signInForm->isValid('email'));
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.never',
        ]);
        $this->assertFalse($signInForm->isValid('email'));
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
    }

    public function testValidOutputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $signInForm->password = ' 12q34e56t78 ';
        $this->assertTrue($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->password);
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $signInForm->setPassword(' 12q34e56t78 ');
        $this->assertTrue($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->getPassword());
        $this->assertEquals('12q34e56t78', $signInForm->password);
    }

    public function testInvalidOutputs(): void
    {
        // properties
        $signInForm = new SignInPropertyForm();
        $signInForm->setValues([
            'email' => 'test@gmail.co2m',
        ]);
        $signInForm->password = ' 12q34e56t78 ';
        $this->assertFalse($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->password);
        // methods
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.co2m',
        ]);
        $signInForm->setPassword(' 12q34e56t78 ');
        $this->assertFalse($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->password);
        $this->assertEquals('12q34e56t78', $signInForm->getPassword());
    }

    public function testValidGet(): void
    {
        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertEquals('test@gmail.com', $signInForm->email);
    }

    public function testInvalidGet(): void
    {
        $this->expectException('Bupy7\InputFilter\UnknownPropertyException');

        $signInForm = new SignInMethodForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertEquals('test@gmail.com', $signInForm->unknownEmail);
    }

    public function testValidSet(): void
    {
        $signInForm = new SignInMethodForm();
        $signInForm->email = 'test@gmail.com';
        $this->assertTrue($signInForm->isValid('email'));
    }

    public function testInvalidSet(): void
    {
        $this->expectException('Bupy7\InputFilter\UnknownPropertyException');

        $signInForm = new SignInMethodForm();
        $signInForm->unknownEmail = 'test@gmail.com';
    }

    public function testWriteOnly(): void
    {
        $this->expectException('Bupy7\InputFilter\InvalidCallException');

        $signInForm = new SignInAccessForm();
        $signInForm->password = '12q34e56t78';
        $this->assertTrue($signInForm->isValid('password'));
        $this->assertEquals('12q34e56t78', $signInForm->password);
    }

    public function testReadOnly(): void
    {
        $this->expectException('Bupy7\InputFilter\InvalidCallException');

        $signInForm = new SignInAccessForm();
        $signInForm->email = 'test@gmail.com';
    }

    public function testNullValues(): void
    {
        $signInForm = new NullForm();
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertNull($signInForm->password);
    }

    public function testSetError(): void
    {
        $profileForm = new ProfileForm();
        $profileForm->setValues([
            'age' => 23,
        ]);
        $this->assertTrue($profileForm->isValid());
        $this->assertFalse($profileForm->hasErrors());

        $profileForm->setError('age', 'Today you can only to set age between 50 and 80.');
        $this->assertTrue($profileForm->hasErrors());
    }
}
