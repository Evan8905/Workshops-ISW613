<?php
require_once __DIR__ . '/../utils/auth.php';

logoutUser();

header('Location: /workshop3/index.php?success=logged_out');
