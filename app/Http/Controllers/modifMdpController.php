<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class modifMdpController extends Controller
{
    
    public function affFormModifMdp(){
        $erreur="";
        return view('formModifMdp', compact('erreur'));
    }
    
    public function verifMdp(Request $request){
        $login = Session::get('login');
        $pwd = $request->input('pwd'); 
        $gsb = new GsbFrais();
        //récupérer ancien mot de passe
        //vérifier que mdp saisi = ancien mdp
        //vérifier que les deux mdp tapés st identiques
        //si tout est ok, mettre à jour la bdd
        $erreur="";
         $res = $gsb->getInfosVisiteur($login,$pwd);
          $npwd = $request->input('npwd');
          $n2pwd = $request->input('n2pwd');
         if($npwd != $n2pwd){
             $erreur = "mot de passe différent";
             
         }
        if(empty($res)){
            $erreur = "mot de passe inconnu !";
            return view('formModifMdp', compact('erreur'));
        }
        if ($erreur != ""){
            return view('formModifMdp', compact('erreur'));
        }
        else {
            
            $gsb->modifmdp($npwd, $login);
            return redirect()->back()->with('status', 'Mise à jour effectuée!');
        }
    }
}
