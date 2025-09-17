import { Component } from '@angular/core';
import { NavbarComponent } from '../../../shared/ui/navbar/navbar.component';
import { FooterComponent } from '../../../shared/ui/footer/footer.component';
import { HeroComponent } from './hero/hero.component';

@Component({
  selector: 'app-home',
  imports: [
    NavbarComponent,
    HeroComponent,
    FooterComponent
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

}
