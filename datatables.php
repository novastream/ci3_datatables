<?php

public function get_datatables()
{
    /* General fields for limiting resutls */         
    $start = $this->input->post('start', true);
    $limit = $this->input->post('length', true);
    $draw = $this->input->post('draw', true);

    /**
     * Declare your table fields, if just using 1 table the field name is enough
     * add your table name if joining (table.field)
     * if using concat, use the final name (if first_name and last_name = full_name then 
     * use full_name)
     * This should be the order displayed in datatables
    */
    $table_fields = array(
        0 => 'id',
        1 => 'company_name',
        2 => 'company_postal_address',
        3 => 'contact_person',
        4 => 'company_email',
        5 => 'company_phone'
    );

    /* Declare order variables */
    $order_column = '';
    $order_dir = 'DESC';

    /* If ordering, store the order values */
    if (isset($_POST['order'][0]) && !empty($_POST['order'][0]))
    {
        $o1 = $this->input->post('order', true);
    }

    if (isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']))
    {
        $order_column = $o1[0]['column'];
    }

    if (isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']))
    {
        $order_dir = $o1[0]['dir'];
    }

    /* Declare search variable */
    $search = '';

    /* If search, store the search value */
    if (isset($_POST['search']['value']) && !empty($_POST['search']['value']))
    {
        $s1 = $this->input->post('search', true);
        $search = $s1['value'];
    }

    /* Do your query with CI3 */
    $this->db->select('id, company_name, company_postal_address, contact_person, company_phone, company_email');
    $this->db->from('tbl_customer');

    /* If searching, use CI3 like statements */
    if (!empty($search))
    {
        $this->db->where("(company_name LIKE '%$search%' OR company_postal_address LIKE '%$search%' OR contact_person LIKE '%$search%' OR company_email LIKE '%$search%' OR company_phone LIKE '%$search%')", null, true);
    }

    /* Use custom order only if order_column isset and not empty */
    if (!empty($order_column))
    {
        $this->db->order_by($table_fields[$order_column], $order_dir);
    }
    else
    {
        $this->db->order_by('id', $order_dir);
    }
    
    /* Count filtered result if searching */
    if (!empty($search))
    {
        $tempdb = clone $this->db;
        $tempquery = $tempdb->get();
        $recordsFiltered = $tempquery->num_rows();
    }

    /* Limit the results and perform the query */
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    $data = $query->result_array();

    /* Count the results */
    $recordsTotal = $this->db->count_all('tbl_customer');
    
    if (!isset($recordsFiltered))
    {
        $recordsFiltered = $recordsTotal;
    }

    /* Prepare the JSON data */
    $json_data = array(
        "start"           => intval( $start ),
        "limit"           => intval( $limit ),
        "draw"            => intval( $draw ),
        "recordsTotal"    => intval( $recordsTotal ),  
        "recordsFiltered" => intval( $recordsFiltered ),
        "data"            => $data
    );

    /* Use CI3 output class to display the results */        
    $_output = json_encode($json_data);
    $this->output->set_content_type('application/json');
    $this->output->set_status_header('200');
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
    $this->output->set_header('Pragma: no-cache');
    $this->output->set_header('Access-Control-Allow-Origin: ' . base_url());
    $this->output->set_header('Content-Length: '. strlen($_output));
    $this->output->set_output($_output);
}