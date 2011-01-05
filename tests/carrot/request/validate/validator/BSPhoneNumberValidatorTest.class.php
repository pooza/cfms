<?php
/**
 * @package org.carrot-framework
 */

/**
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSPhoneNumberValidatorTest.class.php 2448 2011-01-02 06:16:45Z pooza $
 * @abstract
 */
class BSPhoneNumberValidatorTest extends BSTest {

	/**
	 * 実行
	 *
	 * @access public
	 */
	public function execute () {
		$this->assert('__construct', $validator = new BSPhoneNumberValidator);
		$this->assert('execute', $validator->execute('00-0000-0000'));
		$this->assert('execute', !$validator->execute('00-0000-00000'));
		$this->assert('execute', !$validator->execute('00000000000'));

		$this->assert('__construct', $validator = new BSPhoneNumberValidator);
		$validator->initialize(array(
			'loose' => true,
		));
		$this->assert('execute', $validator->execute('00-0000-0000'));
		$this->assert('execute', $validator->execute('0000000000'));

		$this->request['tel1'] = '00';
		$this->request['tel2'] = '0000';
		$this->request['tel3'] = '0000';
		$this->assert('__construct', $validator = new BSPhoneNumberValidator);
		$validator->initialize(array(
			'fields' => array('tel1', 'tel2', 'tel3'),
		));
		$this->assert('execute', $validator->execute(null));
	}
}

/* vim:set tabstop=4: */
