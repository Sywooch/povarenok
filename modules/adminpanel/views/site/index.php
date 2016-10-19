<?php
use app\modules\comments\models\UsersComment;
use app\models\User;
use app\modules\recepty\models\Recepty;
use app\modules\article\models\Article;


/* @var $this yii\web\View */

$this->title = 'Панель управления '. \Yii::$app->name;
?>
<div class="site-index">
<div class="row">
	<div class="col-lg-4">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Комментарии</h5>
				<div class="ibox-tools">
					<span class="label label-warning-light"><?= UsersComment::getCountComment($comments->count()); ?></span>
				</div>
			</div>
			<div class="ibox-content">

				<div>
					<div class="feed-activity-list">

						<?php 
						$html = '';
						foreach($comments->all() as $comment) {  

							$com_childs = UsersComment::find()->where(['pid' => $comment->id])->all();
										
							$html .= '<div class="feed-element">
							<a class="pull-left" href="profile.html">
								<img src="' . $comment->user->imagePath . '" class="img-circle" alt="image">
							</a>
							<div class="media-body ">
								<small class="pull-right">' . $comment->dateCreate . '</small>
								<strong>'.$comment->user->name.'</strong> оставил комментарий <a href="'. $comment->table->url .'">'. $comment->table->name .'</a> <br>	
								<small class="text-muted">' . $comment->dateCreate . '</small>
								<p>'.$comment->comment.'</p>';
							if (!empty($com_childs)) {
								foreach($com_childs as $com_child) {
								
									$html .= '<div class="well">
									<strong>'. $comment->user->name .'</strong> <small>ответил</small>
									<div>'. $com_child->comment .'</div>
									</div>';

								}
							}
							$html .= '</div>
							</div>';

						}
						echo $html;
						?>
			
					</div>

					<a href="/adminpanel/users-comment" class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Показать еще</a>

				</div>

			</div>
		</div>

	</div>
	<div class="col-lg-8">
		<div class="row">
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right">Всё время</span>
						<h5>Просмотры</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?= Recepty::find()->sum('count_show'); ?></h1>
						<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
						<small>Всего просмотров</small>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-info pull-right">Всё время</span>
						<h5>Понравилось</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?= $users_like; ?></h1>
						<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
						<small>Всего лайков</small>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right">Всё время</span>
						<h5>Поделились</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?= $users_note; ?></h1>
						<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
						<small>Всего поделилось</small>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right">Всё время</span>
						<h5>Пользователи</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?= User::find()->count(); ?></h1>
						<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
						<small>Всего пользователей</small>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
