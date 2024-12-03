public class Utilisateur {
    private int id;
    private String nom;
    private String email;
    private String motDePasse;
    private String role;

    // Constructeurs, getters et setters
}
public class Article {
    private int id;
    private String titre;
    private String contenu;
    private int utilisateurId; // Référence à l'utilisateur ayant publié l'article

    // Constructeurs, getters et setters
}
public class Commentaire {
    private int id;
    private String contenu;
    private int utilisateurId; // Référence à l'utilisateur ayant posté le commentaire
    private int articleId; // Référence à l'article auquel appartient le commentaire

    // Constructeurs, getters et setters
}

public class UtilisateurDAO {
    private Connection connection;

    public UtilisateurDAO(Connection connection) {
        this.connection = connection;
    }

    public Utilisateur login(String email, String motDePasse) throws SQLException {
        String sql = "SELECT * FROM Utilisateur WHERE email = ? AND mot_de_passe = ?";
        try (PreparedStatement stmt = connection.prepareStatement(sql)) {
            stmt.setString(1, email);
            stmt.setString(2, motDePasse);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                Utilisateur user = new Utilisateur();
                user.setId(rs.getInt("id"));
                user.setNom(rs.getString("nom"));
                user.setEmail(rs.getString("email"));
                user.setMotDePasse(rs.getString("mot_de_passe"));
                user.setRole(rs.getString("role"));
                return user;
            }
            return null;
        }
    }
}

