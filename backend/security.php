<?php
function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function fail($message, $code=400): void { http_response_code($code); echo h($message); exit; }
function go($path): void { header('Location: '.$path, true, 303); exit; }
if (PHP_SAPI !== 'cli') {
    ini_set('display_errors','0');
    ini_set('session.use_strict_mode','1');
    ini_set('session.use_only_cookies','1');
    session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off','samesite'=>'Lax','path'=>'/']);
    session_start();
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: same-origin');
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://stackpath.bootstrapcdn.com; script-src 'self'; frame-ancestors 'none'; base-uri 'none'; form-action 'self'");
    if (isset($_SESSION['last']) && time()-$_SESSION['last']>1800) { $_SESSION=[]; session_regenerate_id(true); }
    $_SESSION['last']=time();
}
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function field(): string { return '<input type="hidden" name="csrf" value="'.h(csrf()).'">'; }
function post(): void {
    if (($_SERVER['REQUEST_METHOD']??'') !== 'POST') fail('Metode tidak diizinkan.',405);
    if (!is_string($_POST['csrf']??null) || !hash_equals(csrf(),$_POST['csrf'])) fail('Token formulir tidak valid.',403);
}
function role($role): void {
    if (($_SESSION['role']??'') !== $role) go('../frontend/view-login-'.$role.'.php');
    $a=new Auction(); $table=$role==='admin'?'tbadmin':'tbuser';
    $q=$a->db->prepare('SELECT id FROM '.$table.' WHERE id=?'); $q->execute([$_SESSION['uid']??0]);
    if (!$q->fetch()) { $_SESSION=[]; fail('Sesi tidak valid.',403); }
}
function val($key): string { $v=$_POST[$key]??null; if (!is_string($v)) fail('Input tidak valid.'); return $v; }
function ident($key): int { $v=filter_var(val($key),FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]); if (!$v) fail('ID tidak valid.'); return $v; }
function money($key): int { $v=filter_var(val($key),FILTER_VALIDATE_INT,['options'=>['min_range'=>1,'max_range'=>1000000000000]]); if (!$v) fail('Harga harus berupa rupiah bulat positif (maksimum 1 triliun).'); return $v; }
function login_session($role,$id): void { session_regenerate_id(true); $_SESSION=['role'=>$role,'uid'=>$id,'last'=>time()]; if ($role==='user') $_SESSION['user_id']=$id; else $_SESSION['admin_logged_in']=true; }
function action_form($file,$id,$class,$label): string { return '<form method="post" action="../backend/'.h($file).'" style="display:inline">'.field().'<input type="hidden" name="id" value="'.h($id).'"><button type="submit" class="'.h($class).'">'.h($label).'</button></form>'; }
function logout_form(): string { return '<form method="post" action="../backend/proses-logout.php" style="display:inline;margin:0">'.field().'<button type="submit" class="logout-btn" style="background:none;border:0;padding:0;cursor:pointer" aria-label="Logout"><img src="../foto/logout.png" alt="Logout" class="logout-logo"></button></form>'; }
function photo($path): string { return preg_match('~^\.\./gambar/[a-f0-9]{32}\.(jpg|png|gif)$~D',(string)$path) ? $path : '../foto/gambar-mobil.jpeg'; }
