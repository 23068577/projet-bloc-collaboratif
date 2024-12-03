import java.sql.*;
import java.util.*;

public class ArticleDAO {
    private Connection connection;

    public ArticleDAO(Connection connection) {
        this.connection = connection;
    }

    public void publierArticle(Article article) throws SQLException {
        String sql = "INSERT INTO Article (titre, contenu, utilisateur_id) VALUES (?, ?, ?)";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setString(1, article.getTitre());
            stmt.setString(2, article.getContenu());
            stmt.setInt(3, article.getUtilisateurId());
            stmt.executeUpdate();
        }
    }

    public List<Article> rechercherArticles(String motCle) throws SQLException {
        String sql = "SELECT * FROM Article WHERE titre LIKE ? OR contenu LIKE ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setString(1, "%" + motCle + "%");
            stmt.setString(2, "%" + motCle + "%");
            ResultSet rs = stmt.executeQuery();
            List<Article> articles = new ArrayList<>();
            while (rs.next()) {
                Article article = new Article();
                article.setId(rs.getInt("id"));
                article.setTitre(rs.getString("titre"));
                article.setContenu(rs.getString("contenu"));
                articles.add(article);
            }
            return articles;
        }
    }

    public List<Commentaire> getCommentaires(int articleId) throws SQLException {
        String sql = "SELECT * FROM Commentaire WHERE article_id = ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setInt(1, articleId);
            ResultSet rs = stmt.executeQuery();
            List<Commentaire> commentaires = new ArrayList<>();
            while (rs.next()) {
                Commentaire commentaire = new Commentaire();
                commentaire.setId(rs.getInt("id"));
                commentaire.setContenu(rs.getString("contenu"));
                commentaires.add(commentaire);
            }
            return commentaires;
        }
    }
}
