<?php
namespace Model;
// use Model\Answer;
class Question extends \Orm\Model {
	protected static $_table_name = 'question';
	protected static $_properties = array('id', 'question');
	protected static $_has_many = array(
	 	'answers' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model\Answer',
	        'key_to' => 'question_id',
            'cascade_save' => true,
        	'cascade_delete' => false,
    		)
 	);
    public static function get_questions()
    {
        $questions = Question::find('all', array('order_by' => array('id' => 'desc') ));
        return $questions;
    }
    public static function get_answers($question_id)
    {
    	$answers = Answer::find('all', array('where' => array(array('question_id', $question_id))));
    	return $answers;
    }

}