<?php

// connect ke database
$link = mysqli_connect(
  "localhost",
  "root",
  "nafkaard17",
  "kampusku"
);

// cek koneksi
if (!$link)
{
    die("Connection failed! " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}
