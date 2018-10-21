<?php

namespace Model\DAL;


class PostDALMySQL extends DALMySQL
{
    public function createTable()
    {
        $createTableQuery = "
          CREATE TABLE `Posts` (
            `id` int(11) NOT NULL,
            `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `title` varchar(50) NOT NULL,
            `content` varchar(500) NOT NULL,
            `userId` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

          ALTER TABLE `Posts`
            ADD PRIMARY KEY (`id`),
            ADD KEY `userId` (`userId`);
  
          ALTER TABLE `Posts`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
            
          ALTER TABLE `Posts`
            ADD CONSTRAINT `Posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`);
            
          COMMIT;
          ";

        $this->createNewTable($createTableQuery);
    }

    public function getAll(): array
    {
        $postList = array();

        try {
            $stmt = $this->db->prepare("
            SELECT Posts.date_created, Posts.title, Posts.content, Users.username
                    FROM Posts LEFT JOIN Users ON Posts.userId = Users.id ORDER BY Posts.date_updated DESC");

            $stmt->execute();

            $this->checkStatementForErrors($stmt->errno);

            $result = $stmt->get_result();

            $stmt->close();

            while ($row = $result->fetch_assoc()) {
                $postList[] = $row;
            }
        } catch (\Exception $e) {
            error_log($e);
        }
        return $postList;
    }

    public function search(string $search): array
    {
        $postList = array();

        $searchQuery = "%" . $search . "%";

        try {
            $stmt = $this->db->prepare("
            SELECT Posts.date_created, Posts.title, Posts.content, Users.username
                    FROM Posts LEFT JOIN Users ON Posts.userId = Users.id 
                    WHERE Posts.title LIKE ? OR Posts.content LIKE ? ORDER BY Posts.date_updated DESC");

                $stmt->bind_param('ss', $searchQuery, $searchQuery);
                $stmt->execute();

                $this->checkStatementForErrors($stmt->errno);

                $result = $stmt->get_result();

                $stmt->close();

                $postList = array();

                while ($row = $result->fetch_assoc()) {
                    $postList[] = $row;
                }
        } catch (\Exception $e) {
            error_log($e);
        }

        return $postList;
    }

    public function add(\Model\PostCredentials $toBeSaved)
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
            throw $e;
        }
    }
}