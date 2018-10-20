<?php

namespace Model\DAL;


class PostDALMySQL extends DALMySQL
{
    public function getAll(): object
    {
        $stmt = $this->db->prepare("
            SELECT Posts.date_created, Posts.title, Posts.content, Users.username
                    FROM Posts LEFT JOIN Users ON Posts.userId = Users.id");
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new \DatabaseFailure(-1);
        }

        $stmt->close();

        return $result;
    }

    public function search(): array
    {

    }

    public function add(\Model\Post $toBeSaved)
    {

    }
}