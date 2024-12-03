import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class LoginWindow extends JFrame {
    private JTextField emailField;
    private JPasswordField passwordField;
    private JButton loginButton;

    public LoginWindow() {
        setTitle("Login");
        setSize(300, 200);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        JPanel panel = new JPanel();
        panel.setLayout(new GridLayout(3, 2));

        panel.add(new JLabel("Email:"));
        emailField = new JTextField();
        panel.add(emailField);

        panel.add(new JLabel("Mot de passe:"));
        passwordField = new JPasswordField();
        panel.add(passwordField);

        loginButton = new JButton("Se connecter");
        panel.add(loginButton);

        add(panel);
        setLocationRelativeTo(null);

        loginButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                // Logique pour vérifier les informations de connexion
            }
        });
    }
}
import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class PublishArticleWindow extends JFrame {
    private JTextField titreField;
    private JTextArea contenuArea;
    private JButton publishButton;

    public PublishArticleWindow() {
        setTitle("Publier un article");
        setSize(400, 300);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);

        JPanel panel = new JPanel();
        panel.setLayout(new GridLayout(3, 2));

        panel.add(new JLabel("Titre:"));
        titreField = new JTextField();
        panel.add(titreField);

        panel.add(new JLabel("Contenu:"));
        contenuArea = new JTextArea();
        panel.add(new JScrollPane(contenuArea));

        publishButton = new JButton("Publier");
        panel.add(publishButton);

        add(panel);
        setLocationRelativeTo(null);

        publishButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                // Logique pour publier un article
            }
        });
    }
}
