<?php

class News extends CI_Controller{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewTitle = "news";
        $this->viewFolder = "news_v";
        $this->load->model("news_model");
    }

    public function index()
    {
        $viewData = new stdClass();
        $items = $this->news_model->get_all(
            array(), "rank ASC"
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewTitle = $this->viewTitle;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewTitle = $this->viewTitle;
        $viewData->subViewFolder = "add";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }
    public function save()
    {
        $this->load->library("form_validation");

        //kurallar
        $news_tpye = $this->input->post("news_type");
        if($news_tpye == "image")
        {
            if($_FILES["img_url"]["name"] == "")
            {
                $alert = array(
					"title" => "İşlem Başarısız",
					"text" => "Lütfen bir görsel Seçiniz!",
					"type" => "error"
				);
                $this->session->set_flashdata("alert", $alert);
			    redirect(base_url("{$this->viewTitle}/new_form"));
                die();
            }
        }
        else if($news_type == "movie")
        {

        }
        die();
        $this->form_validation->set_rules("title","Başlık","required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "{field} alanı doldurulmalıdır!"
            )
        );
        $validate = $this->form_validation->run();
        if($validate)
        {
            $insert = $this->news_model->add(
                array(
                    "title" => $this->input->post("title"),
                    "description" => $this->input->post("description"),
                    "news_type" => "",
                    "img_url" => "",
                    "video_url" => "",
                    "rank" => "",
                )
            );
        }
    }
    public function update_form($id)
    {
        $item = $this->news_model->get(
            array(
                "id" => $id
            )
        );
        $viewData = new stdClass();
        $viewData->viewTitle = $this->viewTitle;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }
    

}

?>