<?php
namespace Model;
use Model\Question;
class Answer extends \Orm\Model {
	protected static $_table_name = 'answer';
	// protected static $_properties = array('id', 'answer', 'question_id');
    protected static $_belongs_to = array(
	    'question' => array(
	        'key_from' => 'question_id',
	        'model_to' => 'Model\Question',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);
    public static function get_answers()
    {
        $answers = Question::find('all', array('order_by' => array('id' => 'desc') ));
        return $answers;
    }

}