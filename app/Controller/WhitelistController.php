<?php 

namespace HeraCMS\Controller;

use PDO;
use HeraCMS;
use HeraCMS\Twig;
use HeraCMS\Model;
use Xesau\SqlXS\QueryBuilder as QB;

class WhitelistController {

	/**
     * Here we got the $_POST from form
     */
	public static function postWhitelist() {
          global $params;

	     /**
         * Let's assign some variables here...
         */
        $countAnswers = 0;

         /**
          * Here we gonna do the verifications of $_POST
          */
          $required = array('name-person', 'steam-hex', 'vdm', 'rdm', 'meta', 'power', 'combat-logging', 'dark', 'safe', 'to-force', 'anti-rp', 'love-life', 'warnings', 'bug', 'wrong', 'high-speed', 'approached', 'pursuit', 'died');

          // Loop over field names, make sure each one exists and is not empty
          $error = false;

          foreach($required as $field) {
               if (isset($_POST[$field]) && empty($_POST[$field])) {
                    $error = true;
               }
          }

          // Here we verify if have errors, if no, proceed
          if ($error) {
               HeraCMS\App::convertJSON(['status' => false, 'message' => 'Você esqueceu de algum campo vazio.']);
          } else {
               // Verify the lenght of name
               if (strlen($_POST['name-person']) > 64) {
                    HeraCMS\App::convertJSON(['status' => false, 'message' => 'Nome do seu personagem está muito grande.']);
               }
               // Verify if the Steam Hex exists on our System
               if (!Model\VrpInfos::verifyHex($_POST['steam-hex'])) {
                    HeraCMS\App::convertJSON(['status' => false, 'message' => 'Você ainda não tem a Steam Hex em nosso sistema.']);
               } 
               
               /**
                * Here we gonna do the verification of answers
                */
               if ($_POST['vdm'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['rdm'] == '1') {
                    $countAnswers++;
               }

               if ($_POST['meta'] == '3') {
                    $countAnswers++;
               }

               if ($_POST['power'] == '3') {
                    $countAnswers++;
               }

               if ($_POST['combat-logging'] == '1') {
                    $countAnswers++;
               }

               if ($_POST['dark'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['safe'] == '1') {
                    $countAnswers++;
               }

               if ($_POST['to-force'] == '3') {
                    $countAnswers++;
               }

               if ($_POST['anti-rp'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['love-life'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['warnings'] == '3') {
                    $countAnswers++;
               }

               if ($_POST['bug'] == '1') {
                    $countAnswers++;
               }

               if ($_POST['wrong'] == '3') {
                    $countAnswers++;
               }

               if ($_POST['high-speed'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['approached'] == '1') {
                    $countAnswers++;
               }

               if ($_POST['pursuit'] == '2') {
                    $countAnswers++;
               }

               if ($_POST['died'] == '3') {
                    $countAnswers++;
               }

               if (!$error && $countAnswers >= $params['whitelist_count_hits']) {
                    try {
                         $hex = Model\Whitelist::select()->where('steam', QB::EQ, $_POST['steam-hex'])->find();

                         if ($hex->getSuccess() == '1') {
                              HeraCMS\App::convertJSON(['status' => false, 'message' => 'Você já está habilitado a entrar em nossa cidade.']);
                         } elseif ($hex->getBlocked() == '1') {
                              HeraCMS\App::convertJSON(['status' => false, 'message' => 'Você está bloqueado a fazer nossa Whitelist. Contate nosso Suporte no Discord.']);
                         }
                    } catch (\RangeException $ex) {
                         Model\Whitelist::insertWhitelist($_POST['name-person'], $_POST['steam-hex'], $countAnswers, 'success');
     
                         HeraCMS\App::convertJSON(['status' => true, 'message' => 'Sua Whitelist foi liberada! Informe ao suporte para setagem no Discord.']);
                    }
               } else {
                    Model\Whitelist::insertWhitelist($_POST['steam-hex'], $countAnswers, $_POST['name-person'], 'blocked');
                    HeraCMS\App::convertJSON(['status' => false, 'message' => 'Você não conseguiu passar em nossa Whitelist e ela foi bloqueada. Comunique o suporte.']);
               }
          }
	}
}