<?php

namespace Model\DAL;


class PostDALMySQL extends DALMySQL
{
    public function createTable()
    {
        $createTableQuery = "CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        $setPrimaryKeyQuery = "ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);";

        $setAutoIndexQuery = "ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;";


        $this->db->query($createTableQuery);
        $this->db->query($setPrimaryKeyQuery);
        $this->db->query($setAutoIndexQuery);
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT Posts.date_created, Posts.title, Posts.content, Users.username
                    FROM Posts LEFT JOIN Users ON Posts.userId = Users.id ORDER BY Posts.date_updated DESC");
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new DatabaseFailure(-1);
        }

        $stmt->close();

        $postList = array();

        while ($row = $result->fetch_assoc()) {
            $postList[] = $row;
        }

        return $postList;
    }

    public function search(string $search): array
    {
        $searchQuery = "%" . $search . "%";

        $stmt = $this->db->prepare("
            SELECT Posts.date_created, Posts.title, Posts.content, Users.username
                    FROM Posts LEFT JOIN Users ON Posts.userId = Users.id 
                    WHERE Posts.title LIKE ? OR Posts.content LIKE ? ORDER BY Posts.date_updated DESC");
        $stmt->bind_param('ss', $searchQuery, $searchQuery);
        $stmt->execute();

        $this->checkStatementForErrors($stmt->errno);

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new DatabaseFailure(-1);
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
            $userRegistry = new UserDALMySQL($this->db);

            $user = $userRegistry->getByName($toBeSaved->getAuthor());

            $stmt = $this->db->prepare("INSERT INTO Posts (title, content, userId) 
            VALUES 
            (?, ?, ?)");
            $stmt->bind_param("sss",
                $toBeSaved->getTitle(),
                $toBeSaved->getContent(),
                $user['id']
            );
            $stmt->execute();

            $this->checkStatementForErrors($stmt->errno);

            $stmt->close();

        } catch (Exception $e) {
            throw new DatabaseFailure(0);
        }
    }
}