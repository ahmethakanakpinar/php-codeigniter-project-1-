<?php

class User_roles extends CI_Controller{

    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewTitle = "user_roles";
        $this->viewFolder = "user_roles_v";
        $this->load->model("user_role_model");
        if(!get_active_user())
		{
			redirect(base_url("login"));
		}
        // $image_upload = array(
        //     "image_width" => 1280,
        //     "image_height" => 720,
        //     "image_aspect_ratio" => 16/9
        // );
        // $this->session->set_flashdata("image_upload", $image_upload);
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->user_role_model->get_all(
            array()
        );
        $viewData->viewTitle = $this->viewTitle;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $viewData->viewTitle = $this->viewTitle;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function save()
    {
        $this->load->library("form_validation");
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
        $this->form_validation->set_rules("title","Başlık","required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "{field} alanı doldurulmalıdır!"
            )
        );
        $validate = $this->form_validation->run();
        if($validate)
        {
            $file_name = CharConvert(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)). "." .pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);
            image_upload("img_url","new_form");
            $insert = $this->user_role_model->add(
                array(
                    "title"     => $this->input->post("title"),
                    "img_url"   => $file_name,
                    "rank"      => 0,
                    "isActive"  => 0,
                    "createdAt" => date("Y-m-d H:i:s")
                )
            );
            if($insert)
            {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type"  => "success"
                );
            }
            else
            {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type"  => "error"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("{$this->viewTitle}"));

        }
        else
        {
            $viewData = new stdClass();
            $viewData->viewTitle = $this->viewTitle;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "add";
            $viewData->form_error = true;
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }


       
        
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->user_role_model->get(
            array(
                "id" => $id
            )
        );
        $viewData->item = $item;
        $viewData->viewTitle = $this->viewTitle;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function update($id)
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("title", "Başlık", "required|trim");
        $this->form_validation->set_message(
            array(
                "required" => "{field} alanı Doldurulmalıdır!"
            )
        );
        $validate = $this->form_validation->run();
        if($validate)
        {
            if($_FILES["img_url"]["name"] != "")
            {
                $file_name = CharConvert(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)). "." .pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);
                image_upload("img_url","update_form");
                $insert = $this->user_role_model->update(
                    array(
                        "id" => $id
                    ),
                    array(
                        "title"     => $this->input->post("title"),
                        "img_url"   => $file_name
                    )
                );
            }
            else
            {
                $insert = $this->user_role_model->update(
                    array(
                        "id" => $id
                    ),
                    array(
                        "title"     => $this->input->post("title"),
                    )
                );
            }
            if($insert)
            {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde güncellendi",
                    "type"  => "success"
                );
            }
            else
            {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt güncelleme sırasında bir problem oluştu",
                    "type"  => "error"
                );
            }
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("{$this->viewTitle}"));
        }
        else
        {
            $viewData = new stdClass();
            $viewData->item = $this->user_role_model->get(
                array(
                    "id" => $id
                )
            );
            $viewData->viewTitle = $this->viewTitle;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }
    public function isActiveSetter($id)
    {
        if($id)
        {
            $isActive = ($this->input->post("data") === "true") ? 1 : 0;
            $this->user_role_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }
    public function rankSetter()
    {
        $data = $this->input->post("data");
		parse_str($data,$order);
		$items = $order["ord"];
		foreach($items as $rank => $id)
		{
			$this->user_role_model->update(
				array(
					"id" => $id,
					"rank !=" => $rank
				),
				array(
					"rank" => $rank
				)
			);
		}
    }
    public function delete($id)
    {
        $item = $this->user_role_model->get(
            array(
                "id" => $id
            )
        );
        $delete = $this->user_role_model->delete(
            array("id" => $id)
        );
        if($delete)
        {
            $alert = array(
				"title" => "İşlem Başarılı",
				"text" => "Kayıt başarılı bir şekilde silindi",
				"type" => "success"
			);
            unlink("uploads/{$this->viewFolder}/$item->img_url");  //dosyayı belirli bir yoldan silmek için kullanılır.
        }
        else
        {
            $alert = array(
				"title" => "İşlem Başarısız",
				"text" => "Kayıt silme işlemi sırasında bir problem oluştu!",
				"type" => "error"
			);
        }
        $this->session->set_flashdata("alert", $alert);
		redirect(base_url("$this->viewTitle"));
    }
}

?>