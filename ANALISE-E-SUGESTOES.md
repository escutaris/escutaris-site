# Análise e Sugestões — Site Escutaris
> Gerado em 23/05/2026 | Revisão pré-migração para Hostinger

---

## 🔴 Erros Críticos (quebram funcionalidade)

### 1. Links do blog apontam para o domínio antigo
- **Arquivo:** `index.html` linha 2862
- **Problema:** O script `renderBlog()` gera links com URL absoluta `https://www.escutaris.com.br/blog/${blog.button}`. Após a migração para o novo domínio na Hostinger, esses links vão redirecionar o visitante para o site antigo.
- **Correção:** Trocar por URL relativa `blog/${blog.button}` ou atualizar para o novo domínio.

### 2. CSS com URL absoluta do domínio antigo
- **Arquivo:** `assets/css/main.css` linha 2875
- **Problema:** A classe `.card-plan` tem `background-image: url(https://www.escutaris.com.br/assets/css/assets/img/logo-escutaris-removebg-preview.png)` — URL errada e absoluta que vai quebrar na Hostinger.
- **Correção:** Trocar por caminho relativo `url(../img/logo-escutaris-removebg-preview.png)`.

### 3. Typo no popup — "bem-star"
- **Arquivo:** `index.html` linha 206
- **Problema:** Subtítulo do livro diz *"Do adoecimento silencioso à cultura de bem-**star**."* — falta o "e".
- **Correção:** Trocar por "bem-**estar**".

### 4. Typo no card de diagnóstico — "Cliqui"
- **Arquivo:** `index.html` linha 1384
- **Problema:** Botão diz *"Cliqui aqui para ver o passo a passo"*.
- **Correção:** Trocar por "**Clique** aqui para ver o passo a passo".

### 5. Link vazio no corpo da página
- **Arquivo:** `index.html` linha 2111
- **Problema:** Existe um `<a href="index.html" target="_blank" title=""><i class="text-white"></i></a>` — link completamente vazio, sem texto e sem ícone visível. É lixo no código e prejudica SEO.
- **Correção:** Remover o elemento inteiro.

### 6. FontAwesome não carregado mas usado no popup
- **Arquivo:** `index.html` popup
- **Problema:** O botão "Comprar livro!" usa `<i class="fa fa-spotify"></i>` mas a biblioteca FontAwesome não está incluída no `<head>`. O ícone não aparece.
- **Correção:** Ou incluir o CDN do FontAwesome, ou trocar pelo ícone equivalente do Bootstrap Icons (`bi bi-spotify`).

### 7. Nome "Ana Paulla" — verificar se é typo
- **Arquivo:** `index.html` linha 209
- **Problema:** O popup do livro exibe *"Autora: Ana **Paulla** Teixeira"* (com double L). Verificar com a Dra. Ana se é o nome correto ou um erro de digitação.

---

## 🟠 Problemas de SEO

### 8. Canonical URL incorreta
- **Arquivo:** `index.html` linha 73
- **Problema:** `<link rel="canonical" href="index.html" />` — URL relativa não funciona como canonical. Motores de busca ignoram ou interpretam errado.
- **Correção:** Trocar por `<link rel="canonical" href="https://SEU-NOVO-DOMINIO.com.br/" />` após definir o domínio definitivo na Hostinger.

### 9. Imagens de Open Graph e Twitter Card não existem
- **Arquivo:** `index.html` linhas 37 e 53
- **Problema:** As metatags sociais referenciam arquivos que não existem no servidor:
  - `logo-escutaris-social.jpg` (Open Graph)
  - `logo-escutaris-twitter.jpg` (Twitter Card)
  Quando alguém compartilhar o link nas redes sociais, não vai aparecer imagem de preview.
- **Correção:** Criar ou selecionar uma imagem existente (ex: `banner_principal.png`) e atualizar os caminhos.

### 10. Meta tag de verificação Google malformada
- **Arquivo:** `index.html` linha 18
- **Problema:** `content="google-site-verification=sATAlucO..."` — o prefixo `google-site-verification=` não deve estar dentro do `content`. O valor correto é só o código alfanumérico.
- **Correção:** `content="sATAlucOfeNUeeacHFWyegoC4knI8w6VWpetKAq-tic"` (remover o prefixo).

### 11. Faltam robots.txt e sitemap.xml
- **Problema:** O site não tem `robots.txt` nem `sitemap.xml`. Esses arquivos são importantes para que o Google indexe corretamente todas as páginas.
- **Correção:** Criar ambos os arquivos na raiz antes do deploy.

---

## 🟡 Problemas de Conteúdo / Editorial

### 12. Typo no depoimento — "Vida londa"
- **Arquivo:** `index.html` linha 1685
- **Problema:** Depoimento de "Gelo Alagoinhas" diz *"Vida **londa** à Escutaris!!"*.
- **Correção:** Trocar por "Vida **longa** à Escutaris!!".

### 13. Typo no depoimento — "Tantoa"
- **Arquivo:** `index.html` linha 1719
- **Problema:** Depoimento de "Giovana Muniz" diz *"**Tantoa** se fazer, facilitar..."*.
- **Correção:** Trocar por "**Tanto a** se fazer, facilitar...".

### 14. Contador de "2030" como métrica
- **Arquivo:** `index.html` seção Stats
- **Problema:** A seção de números animados exibe "2030" com o rótulo "Referência no Nordeste até 2030". Ver um número pulando de 0 até 2030 confunde o visitante — parece uma data ou contagem regressiva, não uma conquista da empresa.
- **Sugestão:** Substituir por uma métrica real e mais impactante (ex: número de empresas atendidas, trabalhadores avaliados, questionários aplicados).

### 15. Crédito da agência anterior no rodapé
- **Arquivo:** `index.html` linha 2535
- **Problema:** O rodapé ainda exibe *"Desenvolvido por Venx Tecnologia"* com link para o site deles.
- **Correção:** Remover ou substituir.

### 16. Todos os depoimentos com a mesma foto genérica
- **Arquivo:** `index.html` seção Depoimentos
- **Problema:** Os 6 depoimentos usam a mesma imagem `assets/img/comentarios.png` — parece fake e pouco profissional.
- **Sugestão:** Substituir por fotos reais dos clientes (com autorização), ou usar as iniciais do nome em um avatar colorido.

---

## 🔵 Técnico / Performance

### 17. Código JavaScript obfuscado via eval()
- **Arquivo:** `index.html` linha 2687
- **Problema:** O script do Google Translate foi minificado e obfuscado com `eval()`. Além de ser difícil de manter, é considerado má prática de segurança e pode ser bloqueado por algumas políticas de CSP (Content Security Policy).
- **Sugestão:** Usar a implementação padrão do Google Translate sem obfuscação.

### 18. Formulário de contato precisa de backend PHP
- **Arquivo:** `index.html` + `assets/vendor/php-email-form/validate.js`
- **Problema:** O formulário de contato usa a biblioteca `php-email-form` que depende de um arquivo PHP no servidor para enviar e-mails. Atualmente o formulário não tem esse arquivo (`forms/contact.php`).
- **Ação necessária:** Antes do deploy, criar o arquivo `forms/contact.php` com as configurações de e-mail da Hostinger, ou trocar por uma solução de formulário de terceiros (ex: Formspree, EmailJS).

### 19. Script do PagesEnse (provável da agência anterior)
- **Arquivo:** `index.html` linha 158
- **Problema:** `<script src="https://cdn.pagesense.io/js/919211394/...">` — esse script provavelmente pertence à conta da agência Venx Tecnologia no PagesEnse (ferramenta de analytics/heatmap). Se não transferirem a conta para a Escutaris, ele só está rastreando dados para a agência.
- **Ação necessária:** Verificar se a Escutaris tem acesso a essa conta. Se não tiver, remover o script.

### 20. Favicon inadequado
- **Arquivo:** `index.html` linha 76
- **Problema:** O favicon atual usa `logo-escutaris-removebg-preview.png` — uma imagem grande com fundo transparente. Favicons idealmente devem ser `.ico` ou PNG quadrado de 32x32 ou 64x64 pixels, com versão para apple-touch-icon também.
- **Sugestão:** Criar um favicon dedicado (pode ser gerado em favicon.io) e atualizar as tags.

### 21. jQuery carregado sem defer
- **Arquivo:** `index.html` linha 2829
- **Problema:** O jQuery é carregado de CDN externo no final do body sem atributo `defer`, o que pode atrasar levemente o carregamento final da página.
- **Correção:** Adicionar `defer` à tag `<script>` do jQuery.

---

## ✅ Checklist antes do deploy na Hostinger

- [ ] Atualizar domínio em todos os links absolutos (`https://www.escutaris.com.br/...`)
- [ ] Atualizar canonical URL com o novo domínio
- [ ] Criar ou atualizar imagens de Open Graph e Twitter Card
- [ ] Corrigir meta tag de verificação Google
- [ ] Criar `robots.txt` e `sitemap.xml`
- [ ] Corrigir todos os typos listados acima
- [ ] Remover crédito da Venx Tecnologia no rodapé
- [ ] Resolver formulário de contato (PHP backend ou serviço externo)
- [ ] Verificar e resolver situação do script PagesEnse
- [ ] Criar favicon dedicado
- [ ] Testar site completo localmente antes de subir
