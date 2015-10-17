<?php
define('U_READ', 1 << 0);   // 0001
define('U_CREATE', 1 << 1); // 0010
define('U_EDIT', 1 << 2);   // 0100
define('U_DELETE', 1 << 3); // 1000
define('U_ALL', U_READ | U_CREATE | U_EDIT | U_DELETE); // 1111