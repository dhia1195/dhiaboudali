import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { HttpParams } from "@angular/common/http";

@Injectable({
  providedIn: "root",
})
export class UniversiteService {
  [x: string]: any;

  constructor(private _http: HttpClient) {}

  url: string = "http://localhost:8070/universites";

  public getAllUniversities() {
    return this._http.get(this.url + "/afficheUniv");
  }

  public getUniversiteById(id: number) {
    return this._http.get(`${this.url}/retrieveUniversityById/${id}`);
  }

  public addUniversity(universite: any) {
    return this._http.post(this.url + "/SaveUniv", universite);
  }
  public updateUniversity(universite: any) {
    return this._http.put(this.url + "/ModifUniv", universite);
  }

  public deleteUniversity(universite: any) {
    console.log(universite);
    return this._http.delete(this.url + "/DeleteUniv", {
      body: universite,
    });
  }
  affecterFoyerAUniversite(
    idFoyer: number,
    nomUniversite: string
  ): Observable<any> {
    const headers = new HttpHeaders({ "Content-Type": "application/json" });

    let httpParams = new HttpParams();
    httpParams = httpParams.set("idFoyer", idFoyer.toString());
    httpParams = httpParams.set("nomUniversite", nomUniversite);

    const params = { params: httpParams };

    return this._http.post(`${this.url}/affecter`, null, {
      headers: headers,
      params: httpParams,
    });
  }
}