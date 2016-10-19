<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\NavigationWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrap">
	
	<div class="back-top"><a href="#">Наверх</a></div>
	
	<div class="btn_add_recept">
		<?= Html::a(
			'',
			['/recepty/default/add_recept'],
			['title' => 'Добавить свой рецепт', 'class' => 'fa fa-pencil']) 
		?>	
	</div>

	<div class="container main">

		<div class="page-wrapper">		
			
			<div class="header">	
				
					<div class="row">
					
						<div class="col-sm-3">		
						
							<?= Html::a(
								'Поварёнок',
								['/'],
								['title' => 'ПоварёнОК', 'class' => 'logo']) 
							?>							
						
						</div>
						
						<div class="col-sm-5">

							<?php ActiveForm::begin([
								'action' => '/recepty/search',
								'method' => 'get',
							]); ?>

								<div class="input-group">
							
									<?= Html::input('text','q',\Yii::$app->request->get('q'),['class' => 'form-control pull-left', 'placeholder' => 'Название блюда']); ?>
																		
									<span class="input-group-btn">
										<?= Html::submitButton('Найти', ['class' => 'btn btn-default']) ?>	
									</span>	
									
								</div>
						
							<?php ActiveForm::end(); ?>
		
						</div>
						
						<div class="col-sm-4 top__right-regist">
							
							<div class="row">
							
							<?php if (Yii::$app->user->isGuest): ?>
							
								<ul class="navbar-top-links text-right">		
									
									<li>
										<?= Html::a(
											'Регистрация',
											['/site/register'],
											['title' => 'Регистрация']) 
										?>									
									</li>

									<li>
										<?= Html::a(
											'Войти',
											['/site/login'],
											['title' => 'Войти']) 
										?>								
									</li>

								</ul>				

							<?php else: ?>
						
								<div class="col-xs-8 recepty_notifications">
									<?= Html::a(
										'<span class="glyphicon glyphicon-envelope"></span><span class="answer__label">Мои ответы</span>',
										['/recepty/notifications'],
										['title' => 'Мои ответы', 'class' => 'my-answer']) 
									?>								
								</div>		
								<div class="ava-user col-xs-4 text-right">
									<div class="dropdown-toggle" data-toggle="dropdown">
										<img src="<?= Yii::$app->user->identity->imagePath; ?>" alt="" class="img-circle" style="height: 44px;">
									</div>
									<ul class="dropdown-menu" role="menu">
										<li><?= Html::a('Мои заметки', ['/users/users-like']); ?></li>
										<li><?= Html::a('Настройки', ['/users/settings']); ?></li>
										<li class="divider"></li>
										<?php if (Yii::$app->user->can('admin')) {
											echo '<li>'.Html::a('Админпанель',['/adminpanel']).'</li>';
										} ?>									
										<li><?= Html::a('Выход',['/site/logout'],['data-method'=>'post']); ?></li>
									</ul>
								</div>	
					
							<?php endif; ?>
							</div>
						</div>
					</div>

			</div>
						
			<div class="navigation">
				<?= NavigationWidget::widget(); ?>
			</div>			
			
			<div class="middle">
				<?php 
					echo Alert::widget(); 
	 
					echo Breadcrumbs::widget([
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]); 	
					echo $content;
				
				?>
			</div>
			
		</div>
		
		
		<div class="footer">

			<div class="text-center">
				<div class="footer-va">
					&copy; 2015–<?php echo date('Y'); ?> <a href="http://povarenok.by/">Povarenok.by</a>	
				</div>
				<div class="footer-va__schetchiki">
					<div class="footer-va__body">
						<?= $this->render("//site/schetchik"); ?>		
					</div>		
				</div>				
			</div>
			
		</div>	
		
	</div>	
		
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
