<?php

use app\modules\users\models\UsersLike;

if ($id_variate == UsersLike::LIKE) {
	echo $this->render('@app/modules/users/views/users-like/_form_like',
			[
				'id_table' => $id_table,
				'table_name' => $table_name,
			]); 
}

if ($id_variate == UsersLike::NOTE) {
	echo $this->render('@app/modules/users/views/users-like/_form_note',
			[
				'id_table' => $id_table,
				'table_name' => $table_name,
			]); 
}


?>