import { Component, Input, Output, OnInit, EventEmitter,Renderer2 } from '@angular/core';
import { EtudiantService } from 'src/app/services/etudiant.service';
import { Etudiant } from 'src/app/models/etudiant';
import { Router } from '@angular/router';

@Component({
 selector: 'app-etudiant',
 templateUrl: './etudiant.component.html',
 styleUrls: ['./etudiant.component.css'],
})
export class EtudiantComponent implements OnInit {

 e: Etudiant[] = [];
 newEtudiant: Etudiant = new Etudiant();
 showAddForm: boolean = false;
 filterId: number;
 isFiltered: boolean = false;
 filterText: string = '';
 sortField: string;
 sortDirection: 'asc' | 'desc' = 'asc';
// ajoutSucces: boolean = false; // Initialize ajoutSucces property

 etudiantRemoved: EventEmitter<number> = new EventEmitter<number>();

 constructor(private etudiantService: EtudiantService, private router: Router ,private renderer: Renderer2) {}

 ngOnInit() {
  console.log('ngOnInit');
  this.loadAllEtudiants();
 }
 /*handleAjoutSucces(success: boolean): void {
    this.ajoutSucces = success;
  }*/
 /*handleAjoutEffectue(): void {
    console.log('Ajout effectué');
    // Perform other actions in response to the successful addition
  }
*/
 loadEtudiantsWithReservations() {
  this.etudiantService.getEtudiantsWithReservations().subscribe((etudiants) => {
   this.e = etudiants;
  });
 }

 removeEtudiant(idEtudiant: number) {
  this.etudiantService.removeEtudiant(idEtudiant).subscribe(() => {
   this.e = this.e.filter(etudiant => etudiant.idEtudiant !== idEtudiant);
   this.etudiantRemoved.emit(idEtudiant); // Emit the removed student's ID
  });
 }

 navigateToEtudiantForm() {
  this.router.navigate(['/etudiant-form']);
 }

 navigateToUpdateForm(etudiantId: number) {
  this.router.navigate(['/etudiantUpdate', etudiantId]);
 }

 filterEtudiants() {
  if (this.filterId) {
   this.e = this.e.filter(etudiant => etudiant.idEtudiant === this.filterId);
   this.isFiltered = true;
  } else if (this.filterText) {
   const lowerCaseFilterText = this.filterText.toLowerCase();
   this.e = this.e.filter(etudiant =>
    etudiant.nomEt.toLowerCase().includes(lowerCaseFilterText) ||
    etudiant.prenomEt.toLowerCase().includes(lowerCaseFilterText) ||
    etudiant.ecole.toLowerCase().includes(lowerCaseFilterText)
   );
   this.isFiltered = true;
  } else {
   this.loadAllEtudiants();
   this.isFiltered = false;
  }
 }

 sortEtudiants() {
  if (this.sortField) {
   this.e = this.e.filter(etudiant => etudiant[this.sortField] !== null);

   this.e.sort((a, b) => {
    const fieldA = a[this.sortField].toLowerCase();
    const fieldB = b[this.sortField].toLowerCase();

    if (fieldA < fieldB) {
     return this.sortDirection === 'asc' ? -1 : 1;
    }
    if (fieldA > fieldB) {
     return this.sortDirection === 'asc' ? 1 : -1;
    }
    return 0;
   });
  }
 }

 clearFilter() {
  this.filterId = null;
  this.loadAllEtudiants();
  this.isFiltered = false;
 }

 private loadAllEtudiants() {
  this.etudiantService.getAllEtudiants().subscribe((etudiants) => {
   console.log(etudiants);
   this.e = etudiants;
  });
 }

 navigateToStatistics() {
  this.router.navigate(['/statistique']);
 }

 
}