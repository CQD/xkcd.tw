<?php
header('Content-type: application/json');
header('Cache-Control: public, max-age=10800');
echo json_encode($strips);
