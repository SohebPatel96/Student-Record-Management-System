<?php

namespace App\Repositories\Student;

interface StudentInterface
{
    public function store($name, $phone_number, $email, $country_code);

    public function search($search_text, $page_no);

    public function get_students();

    public function get_student_by_id($id);

    public function update($id, $name, $image);

    public function delete($id);
}
