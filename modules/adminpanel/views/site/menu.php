<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element"> <span>
					<img alt="image" class="img-circle" style="height:50px;" src="<?= Yii::$app->user->identity->imagePath; ?>" />
					 </span>
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= Yii::$app->user->identity->email; ?></strong>
					 </span> <span class="text-muted text-xs block">Администратор <b class="caret"></b></span> </span> </a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a href="/adminpanel/users">Учетные данные</a></li>
						<li class="divider"></li>
						<li><a href="/">Вернуться на сайт</a></li>
					</ul>
				</div>
				<div class="logo-element">
					Aver
				</div>
			</li>
			<li>
				<a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Контент</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/adminpanel/photos">Фотографии</a></li>
					<li><a href="/adminpanel/recepty-tree">Категории рецептов</a></li>
					<li><a href="/adminpanel/recepty">Рецепты</a></li>
					<li><a href="/adminpanel/pages">Страницы</a></li>
					<li><a href="/adminpanel/article">Статьи</a></li>
					<li><a href="/adminpanel/navigation">Навигация</a></li>
				</ul>
			</li>
			<li>
				<a href="/"><i class="fa fa-book"></i> <span class="nav-label">Справочники</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="/adminpanel/ingredients">Ингредиенты</a></li>
					<li><a href="/adminpanel/measures">Мера веса</a></li>
				</ul>			
			</li>
			<li>
				<a href="/adminpanel/users"><i class="fa fa-users"></i> <span class="nav-label">Пользователи</span> </a>
			</li>
			<li>
				<a href="/adminpanel/users-comment"><i class="fa fa-users"></i> <span class="nav-label">Комментарии</span> </a>
			</li>
		</ul>

	</div>
</nav>