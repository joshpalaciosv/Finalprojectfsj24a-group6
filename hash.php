<?php

$hashedPassword = password_hash('password123', PASSWORD_BCRYPT);

// Output the hashed password
echo $hashedPassword;