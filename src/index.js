import $ from "jquery";
import scrollify from "jquery-scrollify";

$(function() {

  //Gestion du scroll sur la page d'accueil
  $.scrollify({
    section : ".mag",
    touchScroll : true,
    scrollbars : false,
    scrollSpeed: 600,
    easing: "linear"
  });

  //Gestion de l'animation du menu principal
  const menuEntries = $('#main-menu > ul > li > a.inactive');
  let menuTexts = [];
  for (let i = 0; i < menuEntries.length; i++) {
    menuTexts[i] = menuEntries[i].textContent.trim();
    (function (entry) {
      setTimeout(() => collapseEntry(entry), 750);
    })(menuEntries[i]);
    menuEntries.eq(i).mouseover(function() {
        $(this).find("span").width('auto');
    });
    menuEntries.eq(i).mouseleave(function() {
      collapseEntry(this);
    })
  }

  //Function qui raccourcit le texte des éléments du menu
  function collapseEntry(entry) {
    $(entry).find("span").animate({
        width: '0'
    });
  }

  //Function récursive qui vide le texte des éléments du menu
  //Non utilisée
  function emptyEntry(entry) {
    setTimeout(function () {
      let nbChars = entry.textContent.trim().length;
      if (nbChars > 2) {
        let text = entry.textContent.trim();
        entry.textContent = text.slice(0,1) + text.slice(2);
        emptyEntry(entry);
      }
    }, 100);
  }

  //Sections d'éléments qui ne concernent que la page article
  const article = $('#article');
  if (article.length) {

    //Gestion du header de la page article
    let headerVisible = false;
    const articleHeader = $('#article-header-container');
    const offset = $('#article-body')[0].offsetTop;
    article.scroll(function () {
      let scrolled = article[0].scrollTop;
      if (scrolled >= offset && !headerVisible) {
        headerVisible = true;
        articleHeader.addClass('show');
      } else if (scrolled < offset && headerVisible) {
        headerVisible = false;
        articleHeader.removeClass('show');
      }
    });

    //Gestion du mode fullscreen
    const fullscreenBtn = $('.icon.resize');
    const body = $('body');
    let fullscreenOn = false;
    fullscreenBtn.click(function () {
      if (!fullscreenOn) {
        fullscreenOn = true;
        body.addClass('fullscreen');
      } else {
        fullscreenOn = false;
        body.removeClass('fullscreen');
      }
    });

    //Gestion de l'agrandissement des images
    const pics = $('#article-aside .pic');
    pics.click(function () {
      let pic = $(this);
      if (!pic.hasClass('pic-full')) {
        pic.addClass('pic-full');
      } else {
        pic.removeClass('pic-full');
      }
    });

    //Gestion de la modification de la taille du texte des articles
    const articleBody = $('#article-body');
    $('#zoom .plus').click(() => zoomArticle(articleBody));
    $('#zoom .minus').click(() => zoomArticle(articleBody, true));

    function zoomArticle(articleBody, back = false) {
      const increment = 1,
            mini = 12,
            max = 24;
      let fontSize = parseInt(articleBody.css('font-size'));
      fontSize += back ? -increment : increment;
      if (fontSize <= max && fontSize >= mini ) articleBody.css('font-size', fontSize);
    }

    //Gestion de la section sommaire du menu principal
    const summary = $('#main-menu .summary');

    //Scrolle la section sommaire du menu principal jusqu'à la bonne entrée
    setTimeout (function() {
      const active = summary.find('p.active');
      if (active.length) {
        let offset = active[0].offsetTop;
        let height = active.outerHeight();
        summary.stop().animate({scrollTop : offset - height}, 1000, 'swing');
      }
    }, 750);

    $('#main-menu .next').click(() => scrollSummary(summary));
    $('#main-menu .previous').click(() => scrollSummary(summary, true));

    //Fonction qui scroll le sommaire du menu principal
    function scrollSummary (summary, back = false) {
      const scrollIncrement = 150;
      let scroll = summary.scrollTop() || 0;
      scroll += back ? -scrollIncrement : scrollIncrement;
      if (scroll) summary.stop().animate({scrollTop : scroll}, 250, 'swing');
    }


    //Gestion du bouton de copie de la citation
    const quoteInput = $('#quote-input');
    const quoteMessage = $('#quote-message');

    $('#quote-btn').click(function () {
      quoteInput.select();
      let copy;
      try {
        copy = document.execCommand('copy');
      } catch (e) {
        copy = false;
      } finally {
        if (copy) {
          quoteMessage.text("Citation copiée dans le presse-papier !");
        } else {
          quoteMessage.text("La copie automatique n'est pas prise en charge par votre navigateur. Merci de copier manuellement.");
        }
      }
    });

  }

});
