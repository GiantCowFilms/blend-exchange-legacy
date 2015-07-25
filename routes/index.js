
/*
 * GET home page.
 */

exports.contribute = function(req, res){
  res.render('contribute', { title: 'Contribute - Blend exchange' })
};

exports.about = function(req, res){
  res.render('about', { title: 'About - Blend exchange' })
};