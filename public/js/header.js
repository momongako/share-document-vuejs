/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/header.js":
/*!********************************!*\
  !*** ./resources/js/header.js ***!
  \********************************/
/***/ (() => {

eval("document.addEventListener(\"DOMContentLoaded\", function () {\n  if (window.innerWidth > 992) {\n    document.querySelectorAll('.navbar .nav-item').forEach(function (everyitem) {\n      everyitem.addEventListener('mouseover', function (e) {\n        var el_link = this.querySelector('a[data-bs-toggle]');\n\n        if (el_link != null) {\n          var nextEl = el_link.nextElementSibling;\n          el_link.classList.add('show');\n          nextEl.classList.add('show');\n        }\n      });\n      everyitem.addEventListener('mouseleave', function (e) {\n        var el_link = this.querySelector('a[data-bs-toggle]');\n\n        if (el_link != null) {\n          var nextEl = el_link.nextElementSibling;\n          el_link.classList.remove('show');\n          nextEl.classList.remove('show');\n        }\n      });\n    });\n  }\n\n  window.addEventListener('scroll', function () {\n    if (window.scrollY > 0) {\n      document.getElementById('header').classList.add('fixed-top'); // add padding top to show content behind navbar\n\n      navbar_height = document.querySelector('.navbar').offsetHeight;\n      document.body.style.paddingTop = navbar_height + 'px';\n    } else {\n      document.getElementById('header').classList.remove('fixed-top'); // remove padding top from body\n\n      document.body.style.paddingTop = '0';\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvaGVhZGVyLmpzPzRmNGQiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwid2luZG93IiwiaW5uZXJXaWR0aCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJmb3JFYWNoIiwiZXZlcnlpdGVtIiwiZSIsImVsX2xpbmsiLCJxdWVyeVNlbGVjdG9yIiwibmV4dEVsIiwibmV4dEVsZW1lbnRTaWJsaW5nIiwiY2xhc3NMaXN0IiwiYWRkIiwicmVtb3ZlIiwic2Nyb2xsWSIsImdldEVsZW1lbnRCeUlkIiwibmF2YmFyX2hlaWdodCIsIm9mZnNldEhlaWdodCIsImJvZHkiLCJzdHlsZSIsInBhZGRpbmdUb3AiXSwibWFwcGluZ3MiOiJBQUFBQSxRQUFRLENBQUNDLGdCQUFULENBQTBCLGtCQUExQixFQUE4QyxZQUFVO0FBQ3BELE1BQUlDLE1BQU0sQ0FBQ0MsVUFBUCxHQUFvQixHQUF4QixFQUE2QjtBQUN6QkgsSUFBQUEsUUFBUSxDQUFDSSxnQkFBVCxDQUEwQixtQkFBMUIsRUFBK0NDLE9BQS9DLENBQXVELFVBQVNDLFNBQVQsRUFBbUI7QUFDdEVBLE1BQUFBLFNBQVMsQ0FBQ0wsZ0JBQVYsQ0FBMkIsV0FBM0IsRUFBd0MsVUFBU00sQ0FBVCxFQUFXO0FBQy9DLFlBQUlDLE9BQU8sR0FBRyxLQUFLQyxhQUFMLENBQW1CLG1CQUFuQixDQUFkOztBQUVBLFlBQUdELE9BQU8sSUFBSSxJQUFkLEVBQW1CO0FBQ2YsY0FBSUUsTUFBTSxHQUFHRixPQUFPLENBQUNHLGtCQUFyQjtBQUNBSCxVQUFBQSxPQUFPLENBQUNJLFNBQVIsQ0FBa0JDLEdBQWxCLENBQXNCLE1BQXRCO0FBQ0FILFVBQUFBLE1BQU0sQ0FBQ0UsU0FBUCxDQUFpQkMsR0FBakIsQ0FBcUIsTUFBckI7QUFDSDtBQUVKLE9BVEQ7QUFVQVAsTUFBQUEsU0FBUyxDQUFDTCxnQkFBVixDQUEyQixZQUEzQixFQUF5QyxVQUFTTSxDQUFULEVBQVc7QUFDaEQsWUFBSUMsT0FBTyxHQUFHLEtBQUtDLGFBQUwsQ0FBbUIsbUJBQW5CLENBQWQ7O0FBRUEsWUFBR0QsT0FBTyxJQUFJLElBQWQsRUFBbUI7QUFDZixjQUFJRSxNQUFNLEdBQUdGLE9BQU8sQ0FBQ0csa0JBQXJCO0FBQ0FILFVBQUFBLE9BQU8sQ0FBQ0ksU0FBUixDQUFrQkUsTUFBbEIsQ0FBeUIsTUFBekI7QUFDQUosVUFBQUEsTUFBTSxDQUFDRSxTQUFQLENBQWlCRSxNQUFqQixDQUF3QixNQUF4QjtBQUNIO0FBRUosT0FURDtBQVVILEtBckJEO0FBc0JIOztBQUNEWixFQUFBQSxNQUFNLENBQUNELGdCQUFQLENBQXdCLFFBQXhCLEVBQWtDLFlBQVc7QUFDekMsUUFBSUMsTUFBTSxDQUFDYSxPQUFQLEdBQWlCLENBQXJCLEVBQXdCO0FBQ3BCZixNQUFBQSxRQUFRLENBQUNnQixjQUFULENBQXdCLFFBQXhCLEVBQWtDSixTQUFsQyxDQUE0Q0MsR0FBNUMsQ0FBZ0QsV0FBaEQsRUFEb0IsQ0FFcEI7O0FBQ0FJLE1BQUFBLGFBQWEsR0FBR2pCLFFBQVEsQ0FBQ1MsYUFBVCxDQUF1QixTQUF2QixFQUFrQ1MsWUFBbEQ7QUFDQWxCLE1BQUFBLFFBQVEsQ0FBQ21CLElBQVQsQ0FBY0MsS0FBZCxDQUFvQkMsVUFBcEIsR0FBaUNKLGFBQWEsR0FBRyxJQUFqRDtBQUNILEtBTEQsTUFLTztBQUNIakIsTUFBQUEsUUFBUSxDQUFDZ0IsY0FBVCxDQUF3QixRQUF4QixFQUFrQ0osU0FBbEMsQ0FBNENFLE1BQTVDLENBQW1ELFdBQW5ELEVBREcsQ0FFSDs7QUFDQWQsTUFBQUEsUUFBUSxDQUFDbUIsSUFBVCxDQUFjQyxLQUFkLENBQW9CQyxVQUFwQixHQUFpQyxHQUFqQztBQUNIO0FBQ0osR0FYRDtBQVlILENBckNEIiwic291cmNlc0NvbnRlbnQiOlsiZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcIkRPTUNvbnRlbnRMb2FkZWRcIiwgZnVuY3Rpb24oKXtcbiAgICBpZiAod2luZG93LmlubmVyV2lkdGggPiA5OTIpIHtcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLm5hdmJhciAubmF2LWl0ZW0nKS5mb3JFYWNoKGZ1bmN0aW9uKGV2ZXJ5aXRlbSl7XG4gICAgICAgICAgICBldmVyeWl0ZW0uYWRkRXZlbnRMaXN0ZW5lcignbW91c2VvdmVyJywgZnVuY3Rpb24oZSl7XG4gICAgICAgICAgICAgICAgbGV0IGVsX2xpbmsgPSB0aGlzLnF1ZXJ5U2VsZWN0b3IoJ2FbZGF0YS1icy10b2dnbGVdJyk7XG5cbiAgICAgICAgICAgICAgICBpZihlbF9saW5rICE9IG51bGwpe1xuICAgICAgICAgICAgICAgICAgICBsZXQgbmV4dEVsID0gZWxfbGluay5uZXh0RWxlbWVudFNpYmxpbmc7XG4gICAgICAgICAgICAgICAgICAgIGVsX2xpbmsuY2xhc3NMaXN0LmFkZCgnc2hvdycpO1xuICAgICAgICAgICAgICAgICAgICBuZXh0RWwuY2xhc3NMaXN0LmFkZCgnc2hvdycpO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBldmVyeWl0ZW0uYWRkRXZlbnRMaXN0ZW5lcignbW91c2VsZWF2ZScsIGZ1bmN0aW9uKGUpe1xuICAgICAgICAgICAgICAgIGxldCBlbF9saW5rID0gdGhpcy5xdWVyeVNlbGVjdG9yKCdhW2RhdGEtYnMtdG9nZ2xlXScpO1xuXG4gICAgICAgICAgICAgICAgaWYoZWxfbGluayAhPSBudWxsKXtcbiAgICAgICAgICAgICAgICAgICAgbGV0IG5leHRFbCA9IGVsX2xpbmsubmV4dEVsZW1lbnRTaWJsaW5nO1xuICAgICAgICAgICAgICAgICAgICBlbF9saW5rLmNsYXNzTGlzdC5yZW1vdmUoJ3Nob3cnKTtcbiAgICAgICAgICAgICAgICAgICAgbmV4dEVsLmNsYXNzTGlzdC5yZW1vdmUoJ3Nob3cnKTtcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIH0pXG4gICAgICAgIH0pO1xuICAgIH1cbiAgICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignc2Nyb2xsJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICh3aW5kb3cuc2Nyb2xsWSA+IDApIHtcbiAgICAgICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdoZWFkZXInKS5jbGFzc0xpc3QuYWRkKCdmaXhlZC10b3AnKTtcbiAgICAgICAgICAgIC8vIGFkZCBwYWRkaW5nIHRvcCB0byBzaG93IGNvbnRlbnQgYmVoaW5kIG5hdmJhclxuICAgICAgICAgICAgbmF2YmFyX2hlaWdodCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5uYXZiYXInKS5vZmZzZXRIZWlnaHQ7XG4gICAgICAgICAgICBkb2N1bWVudC5ib2R5LnN0eWxlLnBhZGRpbmdUb3AgPSBuYXZiYXJfaGVpZ2h0ICsgJ3B4JztcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdoZWFkZXInKS5jbGFzc0xpc3QucmVtb3ZlKCdmaXhlZC10b3AnKTtcbiAgICAgICAgICAgIC8vIHJlbW92ZSBwYWRkaW5nIHRvcCBmcm9tIGJvZHlcbiAgICAgICAgICAgIGRvY3VtZW50LmJvZHkuc3R5bGUucGFkZGluZ1RvcCA9ICcwJztcbiAgICAgICAgfVxuICAgIH0pO1xufSk7XG4iXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2hlYWRlci5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/header.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/header.js"]();
/******/ 	
/******/ })()
;