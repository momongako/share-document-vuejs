import ListPost from './components/ListPost';

import AddCategory from './components/AddCategory';
import EditCategory from './components/EditCategory';
import AddPost from './components/commons/NewPost';
import GetListPostByCategoryId from './components/GetListPostByCategoryId';
import DetailPost from './components/commons/DetailPost';
import EditPost from './components/commons/EditPost';


const routes = [
  {
    path: '/',
    component: ListPost,
    name: 'index',
  },

  {
    path: '/category/add',
    component: AddCategory,
    name: 'addCategory',
  },
  {
    path: '/category/edit/:id',
    component: EditCategory,
    name: 'editCategory'
  },
  {
    path: '/post/add',
    component: AddPost,
    name: 'addPost'
  },
  {
    path: '/post/detail/:id',
    component: DetailPost,
    name: 'detailPost'
  },
{
    path: '/post/edit/:id',
    component: EditPost,
    name: 'editPost'
},
  {
    path: '/get-list-post/:id',
    component: GetListPostByCategoryId,
    name: 'getListPost'
  }
];

export default routes;
