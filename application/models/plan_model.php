<?php
class Plan_model extends CI_Model {

    function insert_monthly_plan($data, $month_year) {
        $this->db->insert_batch('monthly_plan', $data);
    }
    
    function delete_plan($product_id, $month_year) {
        $this->db->where('product_id', $product_id);
        $this->db->where('month_year', $month_year);
        
        $this->db->delete('monthly_plan');
    }
    
    function copy_plan($product_id, $from_month, $to_month) {
        $this->delete_plan($product_id, $to_month);
        
        $sql = "INSERT INTO `monthly_plan`(`month_year`, `supplier_id`, `product_id`, `part_id`, `planned_part_no`, `test_id`, `created`)
        SELECT '".$to_month."', `supplier_id`, `product_id`, `part_id`, `planned_part_no`, `test_id`, NOW()
        FROM `monthly_plan`
        WHERE product_id = ?
        AND month_year = ?";
        
        $pass_array = array($product_id, $from_month);
        
        return $this->db->query($sql, $pass_array);
    }
    
    function get_month_plan($month_year, $filters) {
        $sql = "SELECT mp.id, mp.`month_year`, mp.`supplier_id`, mp.`product_id`, mp.`part_id`, 
        mp.`planned_part_no`, mp.`test_id`, mp.schedule_date,
        p.name as product, s.name as supplier, pp.name as part,
        t.name as test,
        CASE 
            WHEN MAX(tr.completed) IS NULL THEN 'Pending'
            WHEN MAX(tr.completed) = 0 THEN 'In Progress'
            WHEN MAX(tr.completed) = 1 THEN 'Completed'
        END as status
        FROM monthly_plan mp
        INNER JOIN suppliers s
        ON s.id = mp.supplier_id
        INNER JOIN products p
        ON p.id = mp.product_id
        INNER JOIN product_parts pp
        ON mp.part_id = pp.id
        INNER JOIN tests t
        ON t.id = mp.test_id
        LEFT JOIN test_records tr
        ON (
            mp.`month_year` = DATE_FORMAT(tr.`start_date`, '%Y-%m-01')
            AND mp.`supplier_id` = tr.supplier_id
            AND mp.product_id = tr.product_id
            AND mp.part_id = tr.part_id
            AND mp.test_id = tr.test_id
            AND tr.aborted = 0
        )
        WHERE mp.month_year = ?";
        
        
        $pass_array = array($month_year);
        if(!empty($filters['product_id'])) {
            $sql .= " AND mp.product_id = ?";
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= " AND mp.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
        if(!empty($filters['part_id'])) {
            $sql .= " AND mp.part_id = ?";
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['test_id'])) {
            $sql .= " AND mp.test_id = ?";
            $pass_array[] = $filters['test_id'];
        }
        
        $sql .= "GROUP BY mp.`month_year`, mp.product_id, mp.part_id, mp.`supplier_id`, mp.test_id
        ORDER BY pp.name, s.name, t.name";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
}