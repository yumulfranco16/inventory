<?php
// Front controller redirect for installations where the project root is the web root.
header('Location: public/index.php?action=login', true, 302);
exit;
