<?php

if ( !empty( $_SESSION[ 'role' ] ) && isset( $_SESSION[ 'role' ] ) && $_SESSION[ 'role' ] == 'member' ) {
    $todo_count = 0;
    $doing_count = 0;
    $done_count = 0;
    $id = $_SESSION[ 'member_id' ];
    $total_count = $todo_count + $doing_count + $done_count;
    $res = new tache_member();
    $taches = $res->display_todo_taches( $id );
    if ( $taches == null ) {
        $taches = [];
    }
    foreach ( $taches as $tache ) {
        $todo_count++;
    }
    $res = new tache_member();
    $taches = $res->display_doing_taches( $id );
    if ( $taches == null ) {
        $taches = [];
    }
    foreach ( $taches as $tache ) {
        $doing_count++;
    }
    $res = new tache_member();
    $taches = $res->display_done_taches( $id );
    if ( $taches == null ) {
        $taches = [];
    }
    foreach ( $taches as $tache ) {
        $done_count++;
    }
}

?>