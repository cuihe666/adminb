<?php
/**
 * Created by PhpStorm.
 * User: gpf
 * Date: 2017/7/7
 * Time: 下午6:00
 */

namespace backend\controllers;
use yii\web\Controller;

class OperationsController extends Controller
{
	public function actionPageseditor (){
		return $this-> render('pageseditor');
	}
	public function actionSubjectlist() {
		return $this-> render('subjectlist');
	}
	public function actionApp_push() {
		return $this-> render('app_push');
	}
	public function actionAdd_new_push() {
		return $this-> render('add_new_push');
	}
	public function actionBanner_edit() {
		return $this-> render('banner_edit');
	}
	public function actionHot_edit() {
		return $this-> render('hot_edit');
	}
	public function actionOdds_edit() {
		return $this-> render('odds_edit');
	}
	public function actionOperationslocat() {
		return $this-> render('operationslocat');
	}
	public function actionPerson_edit() {
		return $this-> render('person_edit');
	}
	public function actionRecommend_edit() {
		return $this-> render('recommend_edit');
	}
	public function actionStar_edit() {
		return $this-> render('star_edit');
	}
	public function actionTraveltheme_edit() {
		return $this-> render('traveltheme_edit');
	}
//	运营位旅行首页及城市列表页
	public function actionTravel_edit() {
		return $this-> render('travel_edit');
	}
}