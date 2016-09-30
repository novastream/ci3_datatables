# Datatables for Codeigniter 3x

Easy to use boilerplate if you want to use Datatables with Codeigniter 3.

  - List, sort and pagination
  - Search

Use:
  - As is, like a controller
  - Create a library / helper
  - Extend to support multiple tables on the same page

### Installation

Requires [Codeigniter](http://www.codeigniter.com/) 3x to run.

- Copy the code to appropriate controller 
- Modify $table_fields to match your datatable
- Modify the $this->db->select
- Modify search items

Setup datatables and make sure you set serverSide to true. I've included a small example (datatables.js).