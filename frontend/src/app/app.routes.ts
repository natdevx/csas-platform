import { Routes } from '@angular/router';

export const routes: Routes = [
    { path: '', loadComponent: () => import('./features/pages/home/home.component').then(m => m.HomeComponent) },
  { path: 'login', loadComponent: () => import('./features/auth/login/login.component').then(m => m.LoginComponent) },
  { path: 'register', loadComponent: () => import('./features/auth/register/register.component').then(m => m.RegisterComponent) },
  { path: 'dashboard/admin', loadComponent: () => import('./features/dashboard/admin/admin.component').then(m => m.AdminComponent) },
  { path: 'dashboard/professor', loadComponent: () => import('./features/dashboard/professor/professor.component').then(m => m.ProfessorComponent) },
  { path: 'dashboard/student', loadComponent: () => import('./features/dashboard/student/student.component').then(m => m.StudentComponent) },
  { path: 'surveys', loadComponent: () => import('./features/surveys/pages/survey-list/survey-list.component').then(m => m.SurveyListComponent) },
];
