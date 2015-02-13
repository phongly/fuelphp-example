<?php
use Model\Question;
use Model\Answer;
// use \Cache;
class Controller_Question extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	private $title = 'Cache Tut!';
	public function action_index()
	{
        $data = array(); //stores variables going to views
        $data['title'] = $this->title;
        $data['questions'] = Question::get_questions();
		return View::forge('welcome/index', $data);
	}

	public function action_detail($id) 
	{
		$data = array(); //stores variables going to views
		$data['title'] = $this->title;
		// Cache::set('test', 'String to be cached.', 3600 * 3);
		// $content = Cache::get('test');
		// Cache::delete('test');
		Cache::delete_all();

		$data['question'] = Question::find($id);
		$cacheID = 'answer_'.$id;
		try
		{
		    $data['answers'] = Cache::get($cacheID);
		}
		catch (\CacheNotFoundException $e)
		{
			$answers = Question::get_answers($id);
			$data['answers'] = $answers;
			Cache::set($cacheID, $data['answers'], 3600 * 13);
			// return 'gan cache moi nha';
		}	
		$question = Question::find($id);
		if(Input::post('answer') != '')
		{
			$new_answer = new Answer();
			$new_answer->answer = Input::post('answer');
			$question->answers[] = $new_answer;
			$question->save();
		}
		// $answers = Question::get_answers($id);
		// $data['answers'] = $answers;	
		// Cache::delete_all();
		// Cache::delete('test');
		return View::forge('welcome/detail', $data);
	}




	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
