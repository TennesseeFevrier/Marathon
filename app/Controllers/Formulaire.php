<?php
/**
 * Welcome controller
 *
 * @author David Carr - dave@novaframework.com
 * @version 3.0
 */

namespace App\Controllers;

use App\Core\Controller;

use App\Models\Histoire;
use App\Models\Image;
use Nova\Support\Facades\Auth;
use View;
use Session;
use Config;
use Input;
use Validator;

/**
 * Sample controller showing 2 methods and their typical usage.
 */
class Formulaire extends Controller
{
    protected $template = "AdminLTE";
    protected $page;
    private $histoire;
    private $image;

    /**
     * Create and return a View instance.
     */
    public function ajout()
    {
        $tmp = Session::get('histoire', new Histoire(), 'image', new Image());
        return $this->getView()
            ->shares('title', __('ajout'))
            ->with('histoire', $tmp)
            ->with('image', $tmp);

    }

    public function ajoutData(){

            $h = new Histoire();
        $validator=Validator::make(
            array(
                'texte'=>$_POST['texte'],
                'titre'=>$_POST['titre'],
            ),
            array(
                'texte'=>'required', //date ou date_format:format
                'titre'=>'required',
            )
        );
        if($validator->fails()){
            return View::make('Formulaire/Ajout')
                ->shares('title', __('ajoutData'))
                ->with('histoire', $h);

        }
            $h->titre = $_POST['titre'];
            $h->texte = $_POST['texte'];
            $h->creation = date('Y-m-d h:i:s');
            $h->idUtilisateur = Auth::id();
            //$i->url=$_POST['url'];
            $h->save();
            $i = 0;
                 while(Input::hasFile("image$i")) {

                     $img = new Image();

                     $img->titre = $_POST["titreimage$i"];
                     $img->texte = $_POST["texteimage$i"];
                     $img->idHistoire = $h->id;

                     $img->url = uniqid() . "." . Input::file("image$i")->getClientOriginalExtension();

                     //                "/Templates/Default/Assets/images/".uniqid().
                     //                ".".
                     //                Input::file('photo')->getClientOriginalExtension();
                     Input::file("image$i")->move(APPDIR . "Templates/Default/Assets/images/", $img->url);

                     $img->url = "Templates/Default/Assets/images/" . $img->url;


                     $img->save();
                     $i++;

            }
        return View::make('Formulaire/Ajout')
            ->shares('title', __('ajoutData'))
            ->with('histoire', $h);
    }

    /*public function ajoutData()
    {
        $data=Input::only('titre', 'texte', 'url');
        $h=new Histoire();
        $i=new Image();
        $h->titre=$data['titre'];
        $h->texte=$data['texte'];
        $i->url=$data['url'];
        $h->save();
        $i->save();
        return View::make('Formulaire/Ajout')
            ->shares('title', __('ajoutData'))
            ->with('histoire', $h)
            ->with('image', $i);

    }*/

}