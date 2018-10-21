<?php

namespace Model\DAL;


class PostDALMySQL extends DALMySQL
{
    public function getAll(): array
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

        $postList = array();

        while ($row = $result->fetch_assoc()) {
            $postList[] = $row;
        }

        return $postList;
    }

    public function search(): array
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

        $postList = array();

        while ($row = $result->fetch_assoc()) {
            $postList[] = $row;
        }

        return $postList;
    }

    public function add(\Model\Post $toBeSaved)
    {
        try {
            // Select statement for getting correct userId
            $stmt = $this->db->prepare("INSERT INTO Posts (title, content, userId) 
            VALUES 
            (?, ?, SELECT id FROM Users WHERE username = ?)");
            $stmt->bind_param("sss",
                $toBeSaved->getTitle(),
                $toBeSaved->getContent(),
                $toBeSaved->getAuthor()
            );
            $stmt->execute();

            $this->checkStatementForErrors($stmt->errno);

            $stmt->close();

        } catch (Exception $e) {
            throw new DatabaseFailure(0);
        }
    }
}