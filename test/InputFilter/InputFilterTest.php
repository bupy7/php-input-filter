<?php

namespace Bupy7\InputFilter\Test\InputFilter;

use Bupy7\InputFilter\Test\Asset\ProfileFilter;
use Bupy7\InputFilter\Test\TestCase;

/**
 * @author Vasilij Belosludcev <https://github.com/bupy7>
 */
class InputFilterTest extends TestCase
{
    public function testSetMessage()
    {
        $profileFilter = new ProfileFilter;
        $profileFilter->setData(['age' => 23]);

        $this->assertTrue($profileFilter->isValid());
        $this->assertEmpty($profileFilter->getMessages());

        $message = 'Today you can only to set age between 50 and 80.';
        $profileFilter->setMessage('age', $message);

        $this->assertNotEmpty($profileFilter->getMessages());
        $this->assertEquals($message, $profileFilter->getMessages()['age'][0]);
    }

    public function testSetMessageForNotExistsInput()
    {
        $profileFilter = new ProfileFilter;
        $profileFilter->setData(['age' => 23]);

        $this->assertTrue($profileFilter->isValid());
        $this->assertEmpty($profileFilter->getMessages());

        $message = 'Input not exists.';
        $profileFilter->setMessage('not_exists', $message);

        $this->assertEmpty($profileFilter->getMessages());
        $this->assertNotEquals(
            $message,
            isset($profileFilter->getMessages()['not_exists'][0])
                ? $profileFilter->getMessages()['not_exists'][0]
                : ''
        );
    }

    public function testSetMessageForInvalidInput()
    {
        $profileFilter = new ProfileFilter;
        $profileFilter->setData(['age' => 150]);

        $this->assertFalse($profileFilter->isValid());
        $this->assertNotEmpty($profileFilter->getMessages());

        $message = 'You have set age large than you have.';
        $profileFilter->setMessage('age', $message);

        $this->assertNotEmpty($profileFilter->getMessages());
        $this->assertEquals($message, $profileFilter->getMessages()['age'][0]);
    }
}
