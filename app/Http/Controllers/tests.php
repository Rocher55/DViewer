<?php

namespace App\Http\Controllers;


class tests extends Controller
{
    public function index()
    {
        $connexion = ldap_connect("ldaps://ldap1.inserm.fr");
        $set = ldap_set_option($connexion, LDAP_OPT_PROTOCOL_VERSION, 3);
        $bind = @ldap_bind($connexion,'uid=ldapreader-toul,ou=sysusers,dc=local', 'YeEa#hh6e');
        $error = ldap_error($connexion);

        return view('test', compact('bind', 'error', 'set'));
    }

}
