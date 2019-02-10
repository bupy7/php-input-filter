<?php

namespace Bupy7\InputFilter\Test;

use Bupy7\InputFilter\Test\Asset\EmptyForm;
use Bupy7\InputFilter\Test\Asset\SignInFilter;
use Bupy7\InputFilter\Test\Asset\SignInMethodForm;
use Bupy7\InputFilter\Test\Asset\SignInAccessForm;
use Bupy7\InputFilter\Test\Asset\SignInPropertyForm;
use Bupy7\InputFilter\Test\Asset\SignInScenarioForm;
use Bupy7\InputFilter\Test\Asset\NullForm;
use Bupy7\InputFilter\Test\Asset\ProfileForm;
use Zend\InputFilter\InputFilter;

/**
 * @author Vasilij Belosludcev <https://github.com/bupy7>
 */
class FormAstractTest extends TestCase
{
    public function testInstanceInputFilter()
    {
        $signInForm = new SignInPropertyForm;
        $signInForm->setInputFilter(new SignInFilter);
        $this->assertInstanceOf(SignInFilter::class, $signInForm->getInputFilter());
        $signInForm->setValues([]);
        $this->assertFalse($signInForm->isValid());
    }

    public function testEmptyInputs()
    {
        $emptyForm = new EmptyForm;
        $emptyForm->setValues([]);
        $this->assertTrue($emptyForm->isValid());
    }

    public function testValidInputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '12q34e56t78',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertFalse($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '12q34e56t78',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertFalse($signInForm->hasErrors());
    }

    public function testInvalidInputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.never',
            'password' => '',
        ]);
        $this->assertFalse($signInForm->isValid());
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.never',
            'password' => '',
        ]);
        $this->assertFalse($signInForm->isValid());
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
    }

    public function testValidGroupInputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertFalse($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertFalse($signInForm->hasErrors());
    }

    public function testInvalidGroupInputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.never',
        ]);
        $this->assertFalse($signInForm->isValid('email'));
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
        // methods
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.never',
        ]);
        $this->assertFalse($signInForm->isValid('email'));
        $errors = $signInForm->getErrors();
        $this->assertTrue(!empty($errors));
        $this->assertTrue($signInForm->hasErrors());
    }

    public function testValidOutputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $signInForm->password = ' 12q34e56t78 ';
        $this->assertTrue($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->password);
        // methods
        $signInForm = new SignInMethodForm;
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

    public function testInvalidOutputs()
    {
        // properties
        $signInForm = new SignInPropertyForm;
        $signInForm->setValues([
            'email' => 'test@gmail.co2m',
        ]);
        $signInForm->password = ' 12q34e56t78 ';
        $this->assertFalse($signInForm->isValid());
        $values = $signInForm->getValues();
        $this->assertEquals('12q34e56t78', $values['password']);
        $this->assertEquals('12q34e56t78', $signInForm->password);
        // methods
        $signInForm = new SignInMethodForm;
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

    public function testValidGet()
    {
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertEquals('test@gmail.com', $signInForm->email);
    }

    /**
     * @expectedException \Bupy7\InputFilter\Exception\UnknownPropertyException
     */
    public function testInvalidGet()
    {
        $signInForm = new SignInMethodForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
        ]);
        $this->assertTrue($signInForm->isValid('email'));
        $this->assertEquals('test@gmail.com', $signInForm->unknownEmail);
    }

    public function testValidSet()
    {
        $signInForm = new SignInMethodForm;
        $signInForm->email = 'test@gmail.com';
        $this->assertTrue($signInForm->isValid('email'));
    }

    /**
     * @expectedException \Bupy7\InputFilter\Exception\UnknownPropertyException
     */
    public function testInvalidSet()
    {
        $signInForm = new SignInMethodForm;
        $signInForm->unknownEmail = 'test@gmail.com';
    }

    /**
     * @expectedException \Bupy7\InputFilter\Exception\InvalidCallException
     */
    public function testWriteOnly()
    {
        $signInForm = new SignInAccessForm;
        $signInForm->password = '12q34e56t78';
        $this->assertTrue($signInForm->isValid('password'));
        $this->assertEquals('12q34e56t78', $signInForm->password);
    }

    /**
     * @expectedException \Bupy7\InputFilter\Exception\InvalidCallException
     */
    public function testReadOnly()
    {
        $signInForm = new SignInAccessForm;
        $signInForm->email = 'test@gmail.com';
    }

    public function testScenario()
    {
        // DEFAULT scenario
        $signInForm = new SignInScenarioForm;
        $signInForm->email = 'test@gmail.com';
        $signInForm->password = '12q34e56t78';
        $this->assertTrue($signInForm->isValid());
        $this->assertEquals(SignInScenarioForm::SCENARIO_DEFAULT, $signInForm->getScenario());
        // PASSWORD scenario
        $signInForm->setScenario(SignInScenarioForm::SCENARIO_PASSWORD);
        $signInForm->email = null;
        $this->assertTrue($signInForm->isValid());
        $this->assertEquals(SignInScenarioForm::SCENARIO_PASSWORD, $signInForm->getScenario());
    }

    public function testNullValues()
    {
        $signInForm = new NullForm;
        $signInForm->setValues([
            'email' => 'test@gmail.com',
            'password' => '',
        ]);
        $this->assertTrue($signInForm->isValid());
        $this->assertNull($signInForm->password);
    }

    public function testSetError()
    {
        $profileForm = new ProfileForm;
        $profileForm->setValues([
            'age' => 23,
        ]);
        $this->assertTrue($profileForm->isValid());
        $this->assertFalse($profileForm->hasErrors());

        $profileForm->setError('age', 'Today you can only to set age between 50 and 80.');
        $this->assertTrue($profileForm->hasErrors());
    }

    /**
     * @expectedException \Bupy7\InputFilter\Exception\NotSupportedException
     */
    public function testSetMessageException()
    {
        $signInFilter = new ProfileForm;
        $signInFilter->setInputFilter(new InputFilter);
        $signInFilter->setValues([
            'age' => 23,
        ]);

        $this->assertTrue($signInFilter->isValid());

        $signInFilter->setError('email', 'Some error message.');
    }
}
