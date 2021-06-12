<?php
header('Content-type: application/json');
header('Cache-Control: public, max-age=3600');
echo json_encode($strips);
