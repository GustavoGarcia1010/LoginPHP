# 🚀 Ultra Admin - Dashboard System

Este é um sistema de gerenciamento administrativo robusto desenvolvido em PHP, utilizando a arquitetura **MVC (Model-View-Controller)** para garantir uma organização clara, escalável e de fácil manutenção.

---

## 📱 Visualização do Sistema

### 🔐 Página de Login
> Interface limpa e segura para autenticação de administradores.
![Página de Login](https://cdn.discordapp.com/attachments/1233807998007382149/1477740099327365160/image.png?ex=69a5dc36&is=69a48ab6&hm=eaa799f3c5d7a1429428cdafbef32d83e9f532d7554d01b84d02656228d15194&)

### 📝 Página de Cadastro
> Formulário estruturado para registro de novos usuários no sistema.
![Página de Cadastro](https://cdn.discordapp.com/attachments/1233807998007382149/1477740298665726074/image.png?ex=69a5dc66&is=69a48ae6&hm=38a9eb6b4e73294504847472d836f9e4b882961f13b4955096e7b558d9c01a88&)

### 📊 Dashboard Principal
> Painel central com métricas, gráficos em tempo real e controle de navegação.
![Dashboard do Sistema](https://cdn.discordapp.com/attachments/1233807998007382149/1477740238855209190/image.label.png?ex=69a5dc58&is=69a48ad8&hm=b5f0a5fe6b3114dc26d7b48eb94cb2fcb91882fe2fd0c91fb75ba2578e6f12c2&)

---

## 🏗️ Arquitetura do Projeto

O sistema segue os padrões modernos de desenvolvimento web, separando as responsabilidades em três camadas principais:

* **Model (`app/src/model`):** Responsável pela manipulação de dados e lógica de negócio. Contém a conexão com o banco de dados (`Conexao.php`) e a representação da entidade (`Usuario.php`).
* **View (`app/src/view`):** A camada de interface. Aqui fica o `dashboardAdmin.php`, que renderiza o layout, gráficos e estatísticas para o usuário final.
* **Controller (`app/src/controller`):** O intermediário. O `UsuarioController.php` processa as requisições (como o login), aciona os Models necessários e define qual View deve ser exibida.

---

## 📁 Estrutura de Pastas Principal

* **`/auth`**: Contém scripts essenciais de segurança, como a verificação de sessão (`VerificarAdmin.php`) e o script de encerramento seguro (`Logout.php`).
* **`/Public`**: Pasta destinada a assets (CSS, JS, Imagens) ou arquivos acessíveis publicamente.
* **`index.php` (Raiz)**: Atua como o **Front Controller**. Ele interpreta as URLs amigáveis e direciona o fluxo para o Controller ou View correspondente.
* **`.htaccess`**: Configurações do servidor Apache para URLs amigáveis (remove o `.php` da URL).

---

## 🔐 Segurança e Sessão

O sistema implementa um fluxo de segurança rigoroso:

1.  **Sessão Protegida**: Dados do administrador são armazenados em `$_SESSION` no servidor.
2.  **Middleware de Acesso**: O arquivo `VerificarAdmin.php` bloqueia acessos diretos a páginas protegidas.
3.  **Logout Profundo**: Limpa o array de sessão, destrói o cookie e invalida o cache do navegador para impedir o uso do botão "voltar" após o logoff.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.x (Arquitetura MVC)
* **Frontend:** HTML5, CSS3, JavaScript (Chart.js para gráficos)
* **Banco de Dados:** MySQL
* **Ícones:** Font Awesome & Google Fonts (Inter)

---

## 🚀 Como Instalar

1.  **Clone o repositório**:
    ```bash
    git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
    ```
2.  **Banco de Dados**: Importe o arquivo SQL localizado em `app/src/config/database.sql` no seu PHPMyAdmin.
3.  **Configuração**: Certifique-se de que o `mod_rewrite` do Apache está ativado no seu XAMPP.
4.  **Acesso**: Mova a pasta para o `htdocs` e acesse `http://localhost/dashboard`.

---
*Desenvolvido com foco em segurança, modularidade e performance.*