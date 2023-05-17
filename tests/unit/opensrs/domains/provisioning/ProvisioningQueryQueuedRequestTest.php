<?php

use opensrs\domains\provisioning\ProvisioningQueryQueuedRequest;

/**
 * @group provisioning
 * @group ProvisioningQueryQueuedRequest
 */
class ProvisioningQueryQueuedRequestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provProcessPending';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * request_id: ID of the queued
             *   request; queue_request_id is
             *   returned when an order is
             *   queued
             */
            'request_id' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->request_id = time();

        $ns = new ProvisioningQueryQueuedRequest('array', $data);

        $this->assertTrue($ns instanceof ProvisioningQueryQueuedRequest);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing request_id' => array('request_id'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->request_id = time();

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new ProvisioningQueryQueuedRequest('array', $data);
    }
}
