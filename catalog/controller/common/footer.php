<?php
class ControllerCommonFooter extends Controller {
    public function index() {
        $data['text_powered'] = '© ' . date('Y') . ' Orcart Engine';

        return $this->load->view('common/footer', $data);
    }
}
