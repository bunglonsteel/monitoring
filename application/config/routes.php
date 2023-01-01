<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login'] = 'auth';
$route['logout'] = 'auth/logout';
$route['blocked'] = 'auth/blocked';


// Absensi
$route['laporan'] = 'absensi/laporan';
$route['cuti-karyawan'] = 'absensi/cuti_karyawan';

// Notes
$route['notes-section'] = 'notes/notes_section';
$route['list-notes'] = 'notes/list_notes';
$route['notes-standard'] = 'notes/notes_standard';
$route['notes-category'] = 'notes/notes_category';
$route['client'] = 'notes/notes_client';

// Cleanliness
$route['cleanliness-progress'] = 'cleanliness/cleanliness_progress';
$route['laporan-kebersihan'] = 'cleanliness/laporan';
