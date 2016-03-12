<?php

Class HomeController Extends BaseController {

	/**
	 * Главная страница
	 */
	public function index()
	{
		App::view('index');
	}

	/**
	 * Проверочный код
	 */
	public function captcha()
	{
		header('Content-type: image/jpeg');

		$phrase = new Gregwar\Captcha\PhraseBuilder;
		$phrase = $phrase->build(5, '0123456789');

		$builder = new Gregwar\Captcha\CaptchaBuilder($phrase);
		$builder->setBackgroundColor(mt_rand(220,255), mt_rand(220,255), mt_rand(220,255));
		$builder->setDistortion(false)->build()->output();

		$_SESSION['captcha'] = $builder->getPhrase();
	}

	/**
	 * Отправка жалобы
	 */
	public function complaint()
	{
		if (! Request::ajax()) App::redirect('/');

		$token = Request::input('token', true);
		$relate_type = Request::input('type');
		$relate_id = Request::input('id');

		if (User::check() && $token == $_SESSION['token']) {

			$spam = Spam::first(['conditions' => ['relate_type = ? AND relate_id = ?', $relate_type, $relate_id]]);

			if ($spam) exit(json_encode(['status' => 'exists']));

			$spam = new Spam();
			$spam->relate_type = $relate_type;
			$spam->relate_id = $relate_id;
			$spam->user_id = User::get('id');

			if ($spam->save()) {
				exit(json_encode(['status' => 'added']));
			}
		}

		exit(json_encode(['status' => 'error']));
	}

	/**
	 * Обратная связь
	 */
	public function contact()
	{
		$request = Request::input('request');

		if (Request::isMethod('post')) {

			$email = Request::input('email');
			$name = Request::input('name');
			$message = Request::input('message');
			$captcha = Request::input('captcha');

			$errors = [];
			if (! App::isMail($email)) $errors['email'] = 'Неверный формат адреса email';
			if (! $name) $errors['name'] = 'Небходимо заполнить имя отправителя';
			if (! $message) $errors['message'] = 'Необходимо заполнить текст сообщения';
			if ($captcha != $_SESSION['captcha']) $errors['captcha'] = 'Неверный проверочный код';

			if (! $errors) {
				$message = nl2br(e($message));

				$to = [env('SITE_EMAIL') => env('SITE_ADMIN')];
				$subject = 'Новое письмо с сайта';
				$body = App::view('mailer.contact', compact('subject', 'message', 'request'), true);
				$headers['from'] = [$email => $name];

				// Отправка письма
				App::sendMail($to, $subject, $body, $headers);

				App::setFlash('success', 'Письмо успешно отправлено!');
				App::redirect('/');
			} else {
				App::setFlash('danger', $errors);
				App::setInput($_POST);
				App::redirect('/contact');
			}
		}

		App::view('pages.contact', compact('request'));
	}
}
