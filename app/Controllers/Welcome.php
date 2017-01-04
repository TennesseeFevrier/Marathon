<?php
/**
 * Welcome controller
 *
 * @author David Carr - dave@novaframework.com
 * @version 3.0
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Commentaire;
use Nova\Support\Facades\Auth;
use App\Models\Histoire;
use App\Models\Image;
use App\Models\Aime;
use Nova\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use View;

/**
 * Sample controller showing 2 methods and their typical usage.
 */
class Welcome extends Controller
{

    protected $template = "AdminLTE";

    /**
     * Create and return a View instance.
     */
    public function index()
    {

        $i = 0;
        foreach (Histoire::all() as $his ) {
            // return  Histoire::find($his->id)->images;
            $histoires[$i] = Histoire::find($his->id)->images;
            $i++;
        }
        $images = Image::find(1)->histoire;

        ////////////////

        $montab=array();
        $j=0;
        foreach (Histoire::all() as $his){
            $montab[$his->id]=$j;
            //echo $his->id;
            $j++;
        }
        $histoiress = Histoire::all();

        /////////////////

        return View::make('Welcome/Welcome')
            ->shares('title', __('Bienvenue sur E-gloo!'))
            ->with('histoires', $histoires)
            ->with('histoiress', $histoiress)
            ->with('images', $images)
            ->with('index',$montab);
    }

    public function histoire($id)
    {
        $aimeDeja = false;
        $montab=array();
        $i=0;
        $nbHistoires = Histoire::count();
        foreach (Histoire::all() as $his){
            $montab[$his->id]=$i;
            $i++;
        }
        $histoires = Histoire::all();
        $aimes = Aime::all()->where('idHistoire',$id);
        $index=$montab[$id];
        $images = Image::all()->where('idHistoire',$id);

        if (Auth::check()) {
            $querry = Aime::where('idUtilisateur', Auth::id());
            if ($querry->where('idHistoire', $id)->count() > 0)
                $aimeDeja = true;
        }

        return View::make('Histoire/Histoire')
            ->shares('title', __('Bienvenue sur E-gloo!'))
            ->with('histoires', $histoires)
            ->with('images', $images)
            ->with('aimes', $aimes)
            ->with('aimeDeja', $aimeDeja)
            ->with('idHistoire', $id)
            ->with('id',$index);
    }

    public function aime($id)
    {
        if (Auth::check()) {
            $aime = new Aime();
            $aime->idUtilisateur = Auth::id();
            $aime->idHistoire = $id;
            $aime->save();
        }

        return Redirect::to('histoire'.$id);
    }

    public function supprimerAime($id)
    {
        if (Auth::check()) {
            $querry = Aime::where('idUtilisateur', Auth::id())->where('idHistoire', $id)->delete();
        }

        return Redirect::to('histoire'.$id);
    }


    public function ajoutCommentaire($id){
        $c=new Commentaire();
        $c->texte=$_POST['texte'];
        $c->datePost= date('Y-m-d h:i:s');
        $c->idUtilisateur= Auth::id();
        $c->idHistoire=$id;
        $c->save();

        return Redirect::to('histoire'.$id);
    }
}
