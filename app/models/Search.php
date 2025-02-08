<?php

class Search extends Model
{
    protected $movies = 'media';
    protected $genres = 'genres';

    /**
     * Searches for movies and other media in the database.
     * 
     * @param string $query The search term.
     * 
     * @return array The search results.
     */
    public function search($query)
    {
        $sql = "
            SELECT 
                m.id, 
                m.title, 
                m.description, 
                g.name AS genre, 
                m.thumbnail 
            FROM {$this->movies} AS m
            LEFT JOIN {$this->genres} AS g ON m.genre_id = g.id
            WHERE m.title LIKE :query 
            OR m.description LIKE :query 
            OR g.name LIKE :query
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
