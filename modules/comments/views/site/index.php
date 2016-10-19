<?php
use app\models\User;
use app\modules\comments\models\UsersComment;
use yii\helpers\Html;

$id_user = !Yii::$app->user->isGuest ? Yii::$app->user->identity->id : 0;
?>

<?php if (!empty($comments)): ?>
<div class="comment-content">

<?php if (isset($raznica)): ?>
	<div class="comment-header"><a href=""><?= UsersComment::getCountComment($total); ?></a></div>
<?php endif; ?>

	<?php foreach($comments as $com_el): ?>
		<?php $user = User::findOne($com_el->id_user); ?>
		<div class="comment-line">
			<?= Html::a(
				Html::img(
					$user->imagePath, 
					['alt' => $user->name]
				),
				[$user->url],
				['title'=>$user->name, 'class' => 'comment-image']) 
			?>			
			<div class="comment-user comid<?= $com_el->id; ?>">
				<div class="comment-title">
					<strong><?= $user->username; ?></strong>
					<div class="comment-date"><small><?= $com_el->dateCreate; ?></small></div>
					<div class="pull-right hide-comment">
					<?php
						if ($id_user == $com_el->id_user)	{
							echo '<span class="edit-comment" rel="'.$com_el->id.'" data-id="'.$com_el->id_table.'" data-path="/comments/site/edit_form">Изменить</span>
									<span class="remove-comment" data-toggle="modal" data-target=".remove-comment-form" rel="'.$com_el['id'].'" ><span class="glyphicon glyphicon-remove" title="Удалить"></span></span>';	
						} elseif ($id_user != 0) {
							echo '<span class="reply-comment" rel="'.$com_el->id.'" data-id="'.$com_el->id_table.'">Ответить</span>';
						}
					?>
					</div>
				</div>		
				<div class="comment-text"><?php
				if (!empty($com_el->pid)) {
					$row = UsersComment::findOne($com_el->pid);
					$user = User::findOne($row->id_user);
					echo '<strong><a href="'.$user->url.'">'.$user->name.'</a>, </strong>';
				}
				echo $com_el->comment; 
				?></div>
			</div>
		</div>		
	<?php endforeach; ?>			
</div>
<?php endif; ?>