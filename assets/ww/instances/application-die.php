﻿<?php

  // E-Mail получателя (между кавычек). Можно указать несколько - через запятую. Пробелы запрещены.
  $to = 'example@mail.ru';

  // Сообщение об успешной отправке (между кавычек).
  $success = 'Спасибо! Заявка успешно отправлена. В ближайшее время мы с вами свяжемся.';

  if($_POST['name'] and $_POST['tel']){
    $ch = curl_init();
    curl_setopt_array($ch , array(
        CURLOPT_URL            => 'http://ooonedvizhimostizakon.intrumnet.com/onlineforms' ,
        CURLOPT_POST           => true ,
        CURLOPT_RETURNTRANSFER => true ,
        CURLOPT_CUSTOMREQUEST  => "POST" ,
        CURLOPT_POSTFIELDS     => http_build_query(array(
            "action"   => "fillform" ,
            "formtype" => 76 ,
            "data"     => array(
                "def_customer" => array(
                    "name" => $_POST['name'],
                    "phone" => $_POST['tel']
                )
            )
        ))
    ));
    $responseData = json_decode(curl_exec($ch));//Ответ от сервера
    curl_close($ch);
  }

  // ================= Код ниже, без опыта, править не рекомендуется ================= //

  // The connection handler
  include('../ww.obfuscate.php');

  // Create instance
  WW_Form::factory(array(
    'exit' => true,
    'action' => '/assets/ww/instances/application-die.php',
    'fields' => array(
      array(
        'alias' => 'Имя',
        'attributes' => array(
          'placeholder' => 'Ваше имя'
        ),
        'name' => 'name',
        'storing' => true,
        'type' => 'text'
      ), array(
        'alias' => 'Телефон',
        'attributes' => array(
          'placeholder' => 'Телефон для связи'
        ),
        'name' => 'tel',
        'rules' => array(
          array(
            'context' => 'Введите Ваш телефон.',
            'rule' => 'required'
          ),
          array(
            'rule' => 'pattern-mobile'
          )
        ),
        'storing' => true,
        'type' => 'tel'
      )
    ),
    'interval' => 10,
    'mail' => array(
      'subject' => 'Заявка с сайта',
      'to' => $to
    ),
    'name' => 'application-die',
    'protection' => false,
    'successText' => $success,
  ))->ajax();